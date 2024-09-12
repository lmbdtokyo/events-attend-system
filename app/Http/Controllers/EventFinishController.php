<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\Eventfinish;

class EventFinishController extends Controller
{
    public function edit(Event $event)
    {
        if (Auth::user()->type === 'master') {
            $eventfinish = Eventfinish::where('event_id', $event->id)->first();
            return view('events.detail.finish', compact('event', 'eventfinish'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                $eventfinish = Eventfinish::where('event_id', $event->id)->first();
                return view('events.detail.finish', compact('event', 'eventfinish'));
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
                'draft_text' => 'required|string',
                'finish_text' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $eventfinish = Eventfinish::find($event);

            $eventfinish->draft_text = $request->input('draft_text');
            $eventfinish->finish_text = $request->input('finish_text');

            $eventfinish->save();

            return redirect()->route('eventfinish.edit', $eventfinish->event_id)->with('success', '申込完了画面情報を更新しました。');
        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }
    }
}
