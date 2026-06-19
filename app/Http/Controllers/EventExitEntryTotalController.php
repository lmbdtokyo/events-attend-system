<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Eventuser;
use App\Models\Eventqr;
use App\Models\Eventbasic;
use App\Models\Eventrecord;
use Illuminate\Support\Facades\Auth;





class EventExitEntryTotalController extends Controller
{
    public function index(Event $event , Eventuser $eventuser , Eventqr $eventqr , Eventbasic $eventbasic , Eventrecord $eventrecord)
    {
        
        if (Auth::check() && (Auth::user()->type === 'master' || Auth::user()->organization == $event->organization)) {
            
            $totals = [];

            $entryCount = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 1)->count();
            $exitCount = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 2)->count();

            // 登録ユーザー（applicant_id あり）／QRユーザー（applicant_id なし）別の内訳
            $registeredEntryCount = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 1)->whereNotNull('applicant_id')->count();
            $registeredExitCount  = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 2)->whereNotNull('applicant_id')->count();
            $qrEntryCount = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 1)->whereNull('applicant_id')->count();
            $qrExitCount  = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 2)->whereNull('applicant_id')->count();

            // 現在会場にいる人数（entry_flg = 1）の内訳
            $inVenueRegistered = \App\Models\Eventuser::where('event_id', $event->id)->where('entry_flg', 1)->count();
            $inVenueQr = \App\Models\Eventqr::where('event_id', $event->id)->where('entry_flg', 1)->count();

            $eventRecords = \App\Models\Eventrecord::where('event_id', $event->id)->get();

            $eventBasic = \App\Models\Eventbasic::where('event_id', $event->id)->first();

            // 申込者数は承認済み（approval=1）のみカウント（申込者一覧の表示と合わせる）
            $eventUsersQuery = \App\Models\Eventuser::where('event_id', $event->id);
            if ($event->approval == 1) {
                $eventUsersQuery->where('approval', 1);
            }
            $eventUsers = $eventUsersQuery->get();
            $userCount = $eventUsers->count();

            $totals[] = [
                'entry_count' => $entryCount,
                'exit_count' => $exitCount,
                'user_count' => $userCount,
                'registered_entry_count' => $registeredEntryCount,
                'registered_exit_count' => $registeredExitCount,
                'qr_entry_count' => $qrEntryCount,
                'qr_exit_count' => $qrExitCount,
                'in_venue_registered' => $inVenueRegistered,
                'in_venue_qr' => $inVenueQr,
            ];

            // 時間別グラフ用：開催日（event_date JSON）と入退場記録に存在する日付の和集合
            $availableDates = collect();
            $eventDateJson = json_decode($event->event_date, true) ?: [];
            foreach ($eventDateJson as $d) {
                if (!empty($d['date'])) {
                    $availableDates->push(\Carbon\Carbon::parse($d['date'])->format('Y-m-d'));
                }
            }
            foreach ($eventRecords as $record) {
                $availableDates->push(\Carbon\Carbon::parse($record->created_at)->format('Y-m-d'));
            }
            $availableDates = $availableDates->unique()->sort()->values()->all();

            return view('events.detail.totals', ['event' => $event , 'totals' => $totals , 'eventUsers' => $eventUsers , 'eventBasic' => $eventBasic , 'eventRecords' => $eventRecords , 'availableDates' => $availableDates]);


        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }

        
    }
}
