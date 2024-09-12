<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\Evententrymail;
    

class EventEntryMailController extends Controller
{
    public function edit(Event $event)
    {
        if (Auth::user()->type === 'master') {
            $evententrymail = Evententrymail::where('event_id', $event->id)->first();
            return view('events.detail.entrymail', compact('event', 'evententrymail'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                $evententrymail = Evententrymail::where('event_id', $event->id)->first();
                return view('events.detail.entrymail', compact('event', 'evententrymail'));
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

            $evententrymail = Evententrymail::find($event);

            $evententrymail->bcc = $request->input('bcc');
            $evententrymail->title = $request->input('title');
            $evententrymail->text = $request->input('text');

            $evententrymail->save();

            return redirect()->route('evententrymail.edit', $evententrymail->event_id)->with('success', '申込完了メール情報を更新しました。');
        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }
    }
}
