<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventpdfimage;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EventPDFViewController extends Controller
{
    public function edit(Event $event , Eventpdfimage $eventpdfimage)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        if (Auth::user()->type === 'master' || Auth::user()->organization == $event->organization) {
            $eventpdfimage = Eventpdfimage::where('event_id', $event->id)->first();
            return view('events.detail.pdf', compact('eventpdfimage', 'event'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {

                $eventpdfimage = Eventpdfimage::where('event_id', $event->id)->first();
                return view('events.detail.pdf', compact('eventpdfimage', 'event'));
                
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }

    }

    public function update(Request $request, Event $event)
    {

        $rules = [
            'image' => 'nullable|image|max:5120', // 5MB = 5120KB
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventpdfimage = Eventpdfimage::where('event_id', $event->id)->first();

        if ($request->hasFile('image')) {
            if ($eventpdfimage->image) {
                Storage::delete($eventpdfimage->image);
            }

            $path = $request->file('image')->store('public/images');
            $eventpdfimage->image = $path;
        }

        $eventpdfimage->save();

        return redirect()->route('eventpdf.edit', $event->id)->with('success', '画像を更新しました。');
    }
}
