<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventuser;
use App\Models\Eventqr;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventrecord;



class EventScanController extends Controller
{

    public function scan($event, $exitentry)
    {
        if (Auth::check()) {
            return view('events.scan', ['event' => $event, 'exitentry' => $exitentry]);
        } else {
            return redirect()->route('eventuser.login');
        }
    }

    public function userqr($eventId, $qrid , $exitentry , Eventrecord $eventrecord)
    {

        //ユーザーエージェントでユーザーを引き継ぐ
        $userAgent = request()->header('User-Agent');
        $userId = null;

        if (preg_match('/CustomUserAgent\/1\.0; UserID=(\d+)/', $userAgent, $matches)) {
            $userId = $matches[1];
        }else{
            return response()->json(['error' => 'ユーザーエージェントの形式が違います。'], 400);
        }

        if ($exitentry != 1 && $exitentry != 2) {
            return response()->json(['error' => '無効なリクエスト形式です。'], 400);
        }

        $eventuser = Eventuser::where('event_id', $eventId)->where('qr', $qrid)->first();

        if (!$eventuser) {
            return response()->json(['error' => 'QRコードが無効です。'], 404);
        }


        if ($exitentry == 1 && $eventuser->entry_flg == 1) {
            return response()->json(['error' => 'このユーザーは入場中です。'], 400);
        }

        if ($exitentry == 2 && $eventuser->entry_flg == 0) {
            return response()->json(['error' => 'このユーザーは退場済みです。'], 400);
        }


        $eventrecord->event_id = $eventId;
        $eventrecord->applicant_id = $eventuser->id;
        $eventrecord->nonuser_id = null;
        $eventrecord->entry_exit = $exitentry;
        $eventrecord->user_id = $userId;
        $eventrecord->save();

        if ($exitentry == 1) {
            $eventuser->entry_flg = 1;
            $eventuser->save();
        }

        if ($exitentry == 2) {
            $eventuser->entry_flg = 0;
            $eventuser->save();
        }

        return response()->json(['success' => 'QRコードが有効です。', 'user' => $eventuser, 'exitentry' => (int)$exitentry], 200);
    }

    public function nonuserqr($eventId, $qrid , $exitentry , Eventrecord $eventrecord)
    {

        if ($exitentry != 1 && $exitentry != 2) {
            return response()->json(['error' => '無効なリクエスト形式です。'], 400);
        }

        $user = Auth::user();
        $event = Event::find($eventId);

        if (!$user) {
            return response()->json(['error' => 'ユーザーが認証されていません。'], 403);
        }
        if (!$event) {
            return response()->json(['error' => 'イベントが見つかりません。'], 403);
        }
        if ($user->organization !== $event->organization) {
            return response()->json(['error' => 'アクセス権限がありません。ユーザーの組織が一致しません。'], 403);
        }

        $eventnonuser = Eventqr::where('event_id', $eventId)->where('qr_id', $qrid)->first();

        if (!$eventnonuser) {
            return response()->json(['error' => 'QRコードが無効です。'], 404);
        }


        if ($exitentry == 1 && $eventnonuser->entry_flg == 1) {
            return response()->json(['error' => 'このユーザーは入場中です。'], 400);
        }

        if ($exitentry == 2 && $eventnonuser->entry_flg == 0) {
            return response()->json(['error' => 'このユーザーは退場済みです。'], 400);
        }

        $eventrecord->event_id = $eventId;
        $eventrecord->applicant_id = null;
        $eventrecord->nonuser_id = $eventnonuser->id;
        $eventrecord->entry_exit = $exitentry;
        $eventrecord->user_id = $user->id;
        $eventrecord->save();

        if ($exitentry == 1) {
            $eventnonuser->entry_flg = 1;
            $eventnonuser->save();
        }

        if ($exitentry == 2) {
            $eventnonuser->entry_flg = 0;
            $eventnonuser->save();
        }

        return response()->json(['success' => 'QRコードが有効です。', 'user' => $eventnonuser, 'exitentry' => (int)$exitentry], 200);
    }
}
