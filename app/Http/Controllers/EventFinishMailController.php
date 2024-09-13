<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\Eventfinishmail;
use App\Models\Eventprogress;


class EventFinishMailController extends Controller
{
    public function edit(Event $event)
    {
        if (Auth::user()->type === 'master') {
            $eventfinishmail = Eventfinishmail::where('event_id', $event->id)->first();
            return view('events.detail.finishmail', compact('event', 'eventfinishmail'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                $eventfinishmail = Eventfinishmail::where('event_id', $event->id)->first();
                return view('events.detail.finishmail', compact('event', 'eventfinishmail'));
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

            $eventfinishmail = Eventfinishmail::find($event);

            $eventfinishmail->bcc = $request->input('bcc');
            $eventfinishmail->title = $request->input('title');
            $eventfinishmail->text = $request->input('text');

            $eventfinishmail->save();

            $eventProgress = Eventprogress::where('event_id', $event)->first();
            $eventProgress->finish_mail_flg = 1;
            $eventProgress->save();

            return redirect()->route('eventfinishmail.edit', $eventfinishmail->event_id)->with('success', '申込完了メール情報を更新しました。');
        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }
    }
}
