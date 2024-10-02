<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use App\Models\Eventsection;
use Illuminate\Support\Facades\Log;
use App\Models\Eventprogress;
use Illuminate\Support\Facades\Auth;

class EventSectionController extends Controller
{
    public function edit(Event $event)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }


        if (Auth::user()->type === 'master') {

            $eventsections = Eventsection::where('event_id', $event->id)->get();
        return view('events.detail.section', compact('event', 'eventsections'));
            
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {

                $eventsections = Eventsection::where('event_id', $event->id)->get();
                return view('events.detail.section', compact('event', 'eventsections'));
    
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }

        
    }

    public function update(Request $request, $id)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $event = Event::findOrFail($id);
        if (Auth::user()->type === 'master' || Auth::user()->organization == $events->organization) {

                $rules = [
                    'eventsections.*.name' => 'required|string|max:255',
                    'eventsections.*.color' => 'required|string|size:7',
                ];
            
                // 新しい項目が存在する場合のみ、そのバリデーションルールを追加
                if ($request->has('eventsections.new')) {
                    $rules['eventsections.new.name'] = 'required|array';
                    $rules['eventsections.new.name.*'] = 'required|string|max:255';
                    $rules['eventsections.new.color'] = 'required|array';
                    $rules['eventsections.new.color.*'] = 'required|string|size:7';
                }
            
                $validator = Validator::make($request->all(), $rules);
            
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            
                // 既存の区分の更新
                foreach ($request->eventsections as $id => $data) {
                    if (is_numeric($id)) {
                        $eventsection = Eventsection::find($id);
                        if ($eventsection) {
                            if (isset($data['delete']) && $data['delete'] == '1') {
                                $eventsection->delete();
                            } else {
                                $eventsection->update($data);
                            }
                        }
                    }
                }

                // 新しい区分の追加
                if (isset($request->eventsections['new'])) {
                    foreach ($request->eventsections['new']['name'] as $index => $name) {
                        Eventsection::create([
                            'event_id' => $event->id,
                            'name' => $name,
                            'color' => $request->eventsections['new']['color'][$index],
                        ]);
                    }
                }

                return redirect()->route('eventsection.edit', $event)->with('success', '受付区分を更新しました。');

        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }
    }
}
