<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventsetting;
use App\Models\Eventbasic;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use App\Models\Eventsection;
use App\Models\Eventprogress;
use Illuminate\Support\Facades\Auth;

class EventFormController extends Controller
{

    public function edit(Event $event)
    {


        if (Auth::user()->type === 'master') {

            $eventsetting = Eventsetting::where('event_id', $event->id)->first();
            return view('events.detail.form', compact('event', 'eventsetting'));
            
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {

                $eventsetting = Eventsetting::where('event_id', $event->id)->first();
                return view('events.detail.form', compact('event', 'eventsetting'));
                
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
                'company_display_name' => 'nullable|string|max:255',
                'company_flg' => 'nullable|boolean',
                'company_required_flg' => 'nullable|boolean',
                'company_placeholder' => 'nullable|string|max:255',
                'division_display_name' => 'nullable|string|max:255',
                'division_flg' => 'nullable|boolean',
                'division_required_flg' => 'nullable|boolean',
                'division_placeholder' => 'nullable|string|max:255',
                'post_display_name' => 'nullable|string|max:255',
                'post_flg' => 'nullable|boolean',
                'post_required_flg' => 'nullable|boolean',
                'post_placeholder' => 'nullable|string|max:255',
                'postal_code_display_name' => 'nullable|string|max:255',
                'postal_code_flg' => 'nullable|boolean',
                'postal_code_required_flg' => 'nullable|boolean',
                'postal_code_placeholder' => 'nullable|string|max:255',
                'address1_display_name' => 'nullable|string|max:255',
                'address1_flg' => 'nullable|boolean',
                'address1_required_flg' => 'nullable|boolean',
                'address1_placeholder' => 'nullable|string|max:255',
                'address2_display_name' => 'nullable|string|max:255',
                'address2_flg' => 'nullable|boolean',
                'address2_required_flg' => 'nullable|boolean',
                'address2_placeholder' => 'nullable|string|max:255',
                'address3_display_name' => 'nullable|string|max:255',
                'address3_flg' => 'nullable|boolean',
                'address3_required_flg' => 'nullable|boolean',
                'address3_placeholder' => 'nullable|string|max:255',
                'tel_display_name' => 'nullable|string|max:255',
                'tel_flg' => 'nullable|boolean',
                'tel_required_flg' => 'nullable|boolean',
                'tel_placeholder' => 'nullable|string|max:255',
                'birth_display_name' => 'nullable|string|max:255',
                'birth_flg' => 'nullable|boolean',
                'birth_required_flg' => 'nullable|boolean',
                'birth_placeholder' => 'nullable|string|max:255',
                'section_display_name' => 'nullable|string|max:255',
                'section_flg' => 'nullable|boolean',
                'section_required_flg' => 'nullable|boolean',
                'section_placeholder' => 'nullable|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->section_flg && !Eventsection::where('event_id', $event)->exists()) {
                return redirect()->back()->withErrors(['section_flg' => '受付区分が存在しません。受付区分を有効にするには、メニューから受付区分を追加してください。'])->withInput();
            }

            $eventsetting = Eventsetting::where('event_id', $event)->first();

            // トグルボタンがオフになっている場合にデフォルト値0を設定
            $fields = [
                'company_flg', 'company_required_flg', 'division_flg', 'division_required_flg', 
                'post_flg', 'post_required_flg', 'postal_code_flg', 'postal_code_required_flg', 
                'address1_flg', 'address1_required_flg', 'address2_flg', 'address2_required_flg', 
                'address3_flg', 'address3_required_flg', 'tel_flg', 'tel_required_flg', 
                'birth_flg', 'birth_required_flg', 'section_flg', 'section_required_flg'
            ];

            foreach ($fields as $field) {
                if (!$request->has($field)) {
                    $request->merge([$field => 0]);
                }
            }

            $eventsetting->update($request->all());

            //一度更新したらprogressのフラグも変更する
            $eventProgress = Eventprogress::where('event_id', $event)->first();
            $eventProgress->form_setting_flg = 1;
            $eventProgress->save();

            return redirect()->route('eventform.edit', $event)->with('success', '申込フォームの表示設定を更新しました。');

        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }
    }
}
