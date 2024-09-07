<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'title.required' => 'タイトルは必須です。',
            'title.string' => 'タイトルは文字列で入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'description.required' => '説明は必須です。',
            'description.string' => '説明は文字列で入力してください。',
        ]);
    
        Event::create($request->all());
        return redirect()->route('events.index')->with('success', 'イベントを作成しました。');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => [
                'required' => 'タイトルは必須です。',
                'string' => 'タイトルは文字列で入力してください。',
                'max' => 'タイトルは255文字以内で入力してください。',
            ],
            'description' => [
                'required' => '説明は必須です。',
                'string' => '説明は文字列で入力してください。',
            ],
        ]);

        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'イベントを更新しました。');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'イベントを削除しました。');
    }
}
