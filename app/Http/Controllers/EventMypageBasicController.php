<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Eventmypagebasic;

class EventMypageBasicController extends Controller
{
    public function edit(Event $event)
    {
        if (Auth::user()->type === 'master') {
            $eventmypagebasic = Eventmypagebasic::where('event_id', $event->id)->first();
            return view('events.detail.mypagebasic', compact('event', 'eventmypagebasic'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                $eventmypagebasic = Eventmypagebasic::where('event_id', $event->id)->first();
                return view('events.detail.mypagebasic', compact('event', 'eventmypagebasic'));
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
                'title' => 'required|string|max:255',
                'text' => 'required|string',
                'image' => 'nullable|image|max:5120', // 5MB = 5120KB
                'endtime' => 'nullable|date',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $eventmypagebasic = Eventmypagebasic::find($event);

            if ($request->hasFile('image')) {
                if ($eventmypagebasic->image) {
                    Storage::delete($eventmypagebasic->image);
                }

                $path = $request->file('image')->store('public/images');
                $eventmypagebasic->image = $path;
            }

            $eventmypagebasic->title = $request->input('title');
            $eventmypagebasic->text = $request->input('text');
            $eventmypagebasic->endtime = $request->input('endtime');

            $eventmypagebasic->save();

            return redirect()->route('eventmypagebasic.edit', $eventmypagebasic->event_id)->with('success', 'マイページ基本情報を更新しました。');
        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }
    }
}
