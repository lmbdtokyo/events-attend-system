<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Usersorganization;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        if (Auth::user()->type === 'master') {
            $events = Event::paginate(10);
        } else {
            $events = Event::where('organization', Auth::user()->organization)->paginate(10);
        }
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'event_date' => 'required|array',
            'event_date.*.date' => 'required|date',
            'event_date.*.starttime' => 'required|date_format:H:i',
            'event_date.*.endtime' => 'required|date_format:H:i|after:event_date.*.starttime',
            'approval' => 'required|boolean',
        ], [
            'name.required' => 'イベント名は必須です。',
            'name.string' => 'イベント名は文字列で入力してください。',
            'name.max' => 'イベント名は255文字以内で入力してください。',
            'place.required' => '開催場所は必須です。',
            'place.string' => '開催場所は文字列で入力してください。',
            'place.max' => '開催場所は255文字以内で入力してください。',
            'event_date.required' => '開催日時は必須です。',
            'event_date.*.date.required' => '開催日は必須です。',
            'event_date.*.date.date' => '開催日は有効な日付を入力してください。',
            'event_date.*.starttime.required' => '開始時間は必須です。',
            'event_date.*.starttime.date_format' => '開始時間は正しい形式で入力してください。',
            'event_date.*.endtime.required' => '終了時間は必須です。',
            'event_date.*.endtime.date_format' => '終了時間は正しい形式で入力してください。',
            'event_date.*.endtime.after' => '終了時間は開始時間より後である必要があります。',
            'approval.required' => '承認の選択は必須です。',
            'approval.boolean' => '承認は有効な値を選択してください。',
        ]);

        $eventData = $request->all();
        $eventData['event_date'] = json_encode($request->event_date);
    
        Event::create($eventData);
        return redirect()->route('events.index')->with('success', 'イベントを作成しました。');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        if (Auth::user()->type === 'master') {
            return view('events.edit', compact('event'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                \Log::info('条件が一致しました');
                return view('events.edit', compact('event'));
            } else {
                \Log::info('条件が一致しませんでした');
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'event_date' => 'required|array',
            'event_date.*.date' => 'required|date',
            'event_date.*.starttime' => 'required|date_format:H:i',
            'event_date.*.endtime' => 'required|date_format:H:i|after:event_date.*.starttime',
            'approval' => 'required|boolean',
        ], [
            'name.required' => 'イベント名は必須です。',
            'name.string' => 'イベント名は文字列で入力してください。',
            'name.max' => 'イベント名は255文字以内で入力してください。',
            'place.required' => '開催場所は必須です。',
            'place.string' => '開催場所は文字列で入力してください。',
            'place.max' => '開催場所は255文字以内で入力してください。',
            'event_date.required' => '開催日時は必須です。',
            'event_date.*.date.required' => '開催日は必須です。',
            'event_date.*.date.date' => '開催日は有効な日付を入力してください。',
            'event_date.*.starttime.required' => '開始時間は必須です。',
            'event_date.*.starttime.date_format' => '開始時間は正しい形式で入力してください。',
            'event_date.*.endtime.required' => '終了時間は必須です。',
            'event_date.*.endtime.date_format' => '終了時間は正しい形式で入力してください。',
            'event_date.*.endtime.after' => '終了時間は開始時間より後である必要があります。',
            'approval.required' => '承認の選択は必須です。',
            'approval.boolean' => '承認は有効な値を選択してください。',
        ]);

        $event->name = $request->name;
        $event->place = $request->place;
        $event->event_date = json_encode($request->event_date);
        $event->approval = $request->approval;
        $event->save();

        return redirect()->route('events.index')->with('success', 'イベントを更新しました。');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'イベントを削除しました。');
    }
}
