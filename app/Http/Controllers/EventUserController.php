<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventsetting;
use App\Models\Eventbasic;
use App\Models\Eventuser;
use App\Models\Event;
use App\Models\Eventsection;


class EventUserController extends Controller
{
    
    public function form(Event $event)
    {

        //フォームの基本設定、表示期間

        $eventsetting = Eventsetting::where('event_id', $event->id)->first();
        $eventbasic = Eventbasic::where('event_id', $event->id)->first();

        $eventsections = Eventsection::where('event_id', $event->id)->get();
            
        return view('events.user.form', compact('eventsetting','eventbasic','event','eventsections'));
    }

    public function store(Request $request)
    {

        $rules = [
            'company' => $eventsetting->company_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'division' => $eventsetting->division_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'post' => $eventsetting->post_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'postal_code' => $eventsetting->postal_code_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'address1' => $eventsetting->address1_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'address2' => $eventsetting->address2_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'address3' => $eventsetting->address3_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'tel' => $eventsetting->tel_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'birth' => $eventsetting->birth_required_flg ? 'required|date' : 'nullable|date',
            'section' => $eventsetting->section_required_flg ? 'required|exists:eventsections,id' : 'nullable|exists:eventsections,id',
            'login_id' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'approval' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventuser = new Eventuser();
        $eventuser->event_id = $eventsetting->event_id;
        $eventuser->company = $request->input('company');
        $eventuser->division = $request->input('division');
        $eventuser->post = $request->input('post');
        $eventuser->postal_code = $request->input('postal_code');
        $eventuser->address1 = $request->input('address1');
        $eventuser->address2 = $request->input('address2');
        $eventuser->address3 = $request->input('address3');
        $eventuser->tel = $request->input('tel');
        $eventuser->birth = $request->input('birth');
        $eventuser->section_id = $request->input('section');
        $eventuser->login_id = $request->input('login_id');
        $eventuser->password = bcrypt($request->input('password'));
        $eventuser->approval = $request->input('approval');
        $eventuser->save();

        //登録完了メールを送る（e-mail認証までやりたい）

        //QRコードのUUIDを生成して保存
        //QRを作成してPDFに埋め込みつつできたPDFをstorageに保存する
        
        return redirect()->route('eventform.edit', $eventsetting->event_id)->with('success', 'フォーム設定を保存しました。');
    }

}
