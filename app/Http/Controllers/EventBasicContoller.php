<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventbasic;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class EventBasicContoller extends Controller
{
    //

    public function edit(Event $event)
    {
        $eventbasic = Eventbasic::where('event_id', $event->id)->first();
        return view('events.detail.edit', compact('event', 'eventbasic'));
    }

    public function update(Request $request, $event)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'overview_title' => 'required|string',
            'overview_text' => 'required|string',
            'terms' => 'required|string',
            'privacy' => 'required|string',
            'image' => 'nullable|image|max:5120', // 5MB = 5120KB
        ];

        // 受付人数制限がある場合の追加ルール
        if ($request->limit == 1) {
            $rules['limit_number'] = 'required|integer';
        }

        // バリデーションの実行
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventbasic = Eventbasic::find($event);


        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($eventbasic->image) {
                Storage::delete($eventbasic->image);
            }

            // 新しい画像を保存
            $path = $request->file('image')->store('public/images');
            $eventbasic->image = $path;
        }

        // 画像フィールドも含めてすべてのフィールドを更新
        $eventbasic->title = $request->input('title');
        $eventbasic->limit = $request->input('limit');
        $eventbasic->limit_number = $request->input('limit_number');
        $eventbasic->start = $request->input('start');
        $eventbasic->end = $request->input('end');
        $eventbasic->overview_title = $request->input('overview_title');
        $eventbasic->overview_text = $request->input('overview_text');
        $eventbasic->terms = $request->input('terms');
        $eventbasic->privacy = $request->input('privacy');

        $eventbasic->save();

        return redirect()->route('eventbasic.edit', $eventbasic->event_id)->with('success', 'イベント基本情報を更新しました。');
    }

}
