<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Eventuser;
use Illuminate\Support\Facades\Auth;
use App\Mail\ApprovalStatusChangedMail;
use Illuminate\Support\Facades\Mail;


class EventApprovalController extends Controller
{
    public function index(Event $event)
    {
        $user = Auth::user();
        if ($user->organization_id === $event->organization_id) {
            $eventUsers = Eventuser::where('event_id', $event->id)->paginate(50);
            return view('events.user.approval', compact('eventUsers','event'));
        } else {
            return redirect()->route('events.index')->with('error', '権限がありません');
        }
    }

    public function update(Event $event , Request $request, $id)
    {

        $eventUser = Eventuser::findOrFail($request->input('eventuser_id'));
        $eventUser->approval = $request->input('approval');
        $eventUser->save();

        Mail::to($eventUser->mail)->send(new ApprovalStatusChangedMail($eventUser));

        return redirect()->route('event.approval', $eventUser->event_id)->with('success', '申込者の承認状況が更新されました');
    }
}
