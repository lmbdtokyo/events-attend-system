<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventbasic;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use App\Models\Eventprogress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class EventBasicContoller extends Controller
{
    //

    public function edit(Event $event)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        if (Auth::user()->type === 'master') {

            $eventbasic = Eventbasic::where('event_id', $event->id)->first();
            return view('events.detail.edit', compact('event', 'eventbasic'));
            
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {

                $eventbasic = Eventbasic::where('event_id', $event->id)->first();
            return view('events.detail.edit', compact('event', 'eventbasic'));
                
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }

        
    }

    public function update(Request $request, $event)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $events = Event::find($event);
        if (Auth::user()->type === 'master' || Auth::user()->organization == $events->organization) {
            

            //一度更新したらprogressのフラグも変更する
            $eventProgress = Eventprogress::where('event_id', $event)->first();
            $eventProgress->form_basic_flg = 1;
            $eventProgress->save();

            $rules = [
                'title' => 'required|string|max:255',
                'overview_title' => 'required|string',
                'overview_text' => 'required|string',
                'terms' => 'required|string',
                'privacy' => 'required|string',
                'image' => 'nullable|image|max:5120',
            ];

            $messages = [
                'title.required' => 'フォームのタイトルは必須です。',
                'title.string' => 'フォームのタイトルは文字列でなければなりません。',
                'title.max' => 'フォームのタイトルは255文字以内でなければなりません。',
                'overview_title.required' => '概要タイトルは必須です。',
                'overview_title.string' => '概要タイトルは文字列でなければなりません。',
                'overview_text.required' => '概要テキストは必須です。',
                'overview_text.string' => '概要テキストは文字列でなければなりません。',
                'terms.required' => '利用規約は必須です。',
                'terms.string' => '利用規約は文字列でなければなりません。',
                'privacy.required' => 'プライバシーポリシーは必須です。',
                'privacy.string' => 'プライバシーポリシーは文字列でなければなりません。',
                'image.image' => '画像ファイルをアップロードしてください。',
                'image.max' => '画像のサイズは5MB以下でなければなりません。',
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




        } else {
            return redirect()->route('events.index')->with('error', '権限がありません。');
        }

    }

}
