<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventsurvey;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;


class EventSurveyController extends Controller
{
    public function edit(Event $event , Eventsurvey $eventSurvey)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        if (Auth::user()->type === 'master' || Auth::user()->organization == $event->organization) {
            $eventSurvey = Eventsurvey::where('event_id', $event->id)->first();
            $eventsurveys = json_decode($eventSurvey->qa, true);
            return view('events.detail.survey', compact('event', 'eventsurveys'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                $eventSurvey = Eventsurvey::where('event_id', $event->id)->first();
                $eventsurveys = json_decode($eventSurvey->qa, true);
                return view('events.detail.survey', compact('event', 'eventsurveys'));
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }
    }

    public function update(Request $request, $event)
    {
  
        $rules = [
            'qa.*' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventSurvey = Eventsurvey::where('event_id', $event)->first();
        $eventSurvey->qa = json_encode($request->input('qa'));
        $eventSurvey->save();

        return redirect()->route('eventsurvey.edit', $event)->with('success', 'アンケート情報を更新しました。');
    }
}
