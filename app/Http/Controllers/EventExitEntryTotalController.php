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


        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }

        
    }
}
