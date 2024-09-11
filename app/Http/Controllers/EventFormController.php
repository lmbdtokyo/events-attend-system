<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventsetting;
use App\Models\Event;

class EventFormController extends Controller
{
    public function edit(Event $event)
    {
        $eventsetting = Eventsetting::where('event_id', $event->id)->first();
        return view('events.detail.form', compact('event', 'eventsetting'));
    }

    public function update(Request $request, $event)
    {
        $rules = [
            'company_display_name' => 'nullable|string|max:255',
            'company_flg' => 'nullable|boolean',
            'company_placeholder' => 'nullable|string|max:255',
            'division_display_name' => 'nullable|string|max:255',
            'division_flg' => 'nullable|boolean',
            'division_placeholder' => 'nullable|string|max:255',
            'post_display_name' => 'nullable|string|max:255',
            'post_flg' => 'nullable|boolean',
            'post_placeholder' => 'nullable|string|max:255',
            'postal_code_display_name' => 'nullable|string|max:255',
            'postal_code_flg' => 'nullable|boolean',
            'postal_code_placeholder' => 'nullable|string|max:255',
            'address1_display_name' => 'nullable|string|max:255',
            'address1_code_flg' => 'nullable|boolean',
            'address1_code_placeholder' => 'nullable|string|max:255',
            'address2_display_name' => 'nullable|string|max:255',
            'address2_code_flg' => 'nullable|boolean',
            'address2_code_placeholder' => 'nullable|string|max:255',
            'address3_display_name' => 'nullable|string|max:255',
            'address3_code_flg' => 'nullable|boolean',
            'address3_code_placeholder' => 'nullable|string|max:255',
            'tel_display_name' => 'nullable|string|max:255',
            'tel_code_flg' => 'nullable|boolean',
            'tel_code_placeholder' => 'nullable|string|max:255',
            'birth_display_name' => 'nullable|string|max:255',
            'birth_code_flg' => 'nullable|boolean',
            'birth_code_placeholder' => 'nullable|string|max:255',
            'section_display_name' => 'nullable|string|max:255',
            'section_code_flg' => 'nullable|boolean',
            'section_code_placeholder' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventsetting = Eventsetting::where('event_id', $event)->first();

        $eventsetting->update($request->all());

        return redirect()->route('eventform.edit', $event)->with('success', 'フォーム設定を更新しました。');
    }
}
