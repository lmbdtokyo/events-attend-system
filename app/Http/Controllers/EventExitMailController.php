<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\Eventexitmail;
use App\Models\Eventprogress;




class EventExitMailController extends Controller
{
    public function edit(Event $event)
    {
    if (Auth::user()->type === 'master') {
        $eventexitmail = Eventexitmail::where('event_id', $event->id)->first();
        return view('events.detail.exitmail', compact('event', 'eventexitmail'));
    } else {
        $user = Auth::user();
        if ($user->organization == $event->organization) {
            $eventexitmail = Eventexitmail::where('event_id', $event->id)->first();
            return view('events.detail.exitmail', compact('event', 'eventexitmail'));
        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }
    }
}

public function update(Request $request, $event)
{
    $events = Event::find($event);
    if (Auth::user()->type === 'master' || Auth::user()->organization == $events->organization) {
        $rules = [
            'bcc' => 'nullable|string|regex:/^([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,},?)+$/',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventexitmail = Eventexitmail::find($event);

        $eventexitmail->bcc = $request->input('bcc');
        $eventexitmail->title = $request->input('title');
        $eventexitmail->text = $request->input('text');

        $eventexitmail->save();

        $eventProgress = Eventprogress::where('event_id', $event)->first();
        $eventProgress->exit_mail_flg = 1;
        $eventProgress->save();

        return redirect()->route('eventexitmail.edit', $eventexitmail->event_id)->with('success', '退場メール情報を更新しました。');
    } else {
        return redirect()->route('events.index')->with('error', '権限がありません。');
    }
    }
}
