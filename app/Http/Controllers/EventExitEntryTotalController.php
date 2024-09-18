<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Eventuser;
use App\Models\Eventqr;
use App\Models\Eventbasic;
use App\Models\Eventrecord;





class EventExitEntryTotalController extends Controller
{
    public function index(Event $event , Eventuser $eventuser , Eventqr $eventqr , Eventbasic $eventbasic , Eventrecord $eventrecord)
    {
        // イベントの入退場の合計を取得するロジックをここに記述します
        // 例として、全イベントの入場者数と退場者数を取得するコードを記述します

        $totals = [];

        $entryCount = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 1)->count();
        $exitCount = \App\Models\Eventrecord::where('event_id', $event->id)->where('entry_exit', 2)->count();

        $eventRecords = \App\Models\Eventrecord::where('event_id', $event->id)->get();

        $eventBasic = \App\Models\Eventbasic::where('event_id', $event->id)->first();

        $eventUsers = \App\Models\Eventuser::where('event_id', $event->id)->get();
        $userCount = $eventUsers->count();

        $totals[] = [
            'entry_count' => $entryCount,
            'exit_count' => $exitCount,
            'user_count' => $userCount,
        ];

        return view('events.detail.totals', ['event' => $event , 'totals' => $totals , 'eventUsers' => $eventUsers , 'eventBasic' => $eventBasic , 'eventRecords' => $eventRecords]);
    }
}
