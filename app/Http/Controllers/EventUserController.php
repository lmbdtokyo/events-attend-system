<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventsetting;
use App\Models\Eventbasic;
use App\Models\Eventuser;
use App\Models\Event;
use App\Models\Eventsection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use App\Models\Eventpdfimage;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventmypagebasic;
use App\Models\Eventprogress;

use App\Models\Eventfinish;




class EventUserController extends Controller
{

    public function finish(Event $event)
    {
        // eventfinishの内容を取得
        $eventfinish = Eventfinish::where('event_id', $event->id)->first();

        // approvalに応じてdraft_textまたはfinish_textを渡す
        $text = $eventfinish && $eventfinish->approval == 1 ? $eventfinish->draft_text : $eventfinish->finish_text;

        // 申込完了画面の表示
        return view('events.user.finish', compact('event', 'text'));
    }

    public function showLoginForm(Event $event)
    {

        if (auth()->guard('eventuser')->check()) {
            $eventuser = auth()->guard('eventuser')->user();
            if ($eventuser->event_id == $event->id) {
                return redirect()->intended("/events/{$event->id}/mypage");
            }
        }

        return view('events.user.login', compact('event'));
    }

    public function login(Request $request , $event)
    {

        $credentials = $request->only('login_id', 'password');
        $event_id = $event;

        $eventuser = Eventuser::where('login_id', $credentials['login_id'])
                              ->where('event_id', $event_id)
                              ->first();

        if ($eventuser && auth()->guard('eventuser')->attempt($credentials)) {
            return redirect()->intended("/events/{$event_id}/mypage");
        }

        return back()->withErrors([
            'login_id' => 'ログインIDまたはパスワードが正しくありません。',
        ]);

    }
    
    public function form(Event $event)
    {

        $eventprogress = Eventprogress::where('event_id', $event->id)->get();

        $eventsetting = Eventsetting::where('event_id', $event->id)->first();
        $eventbasic = Eventbasic::where('event_id', $event->id)->first();

        $eventsections = Eventsection::where('event_id', $event->id)->get();

        
        
        $requiredFlags = [
            'form_basic_flg',
            'form_setting_flg',
            'mypage_basic_flg',
            'finish_flg',
            'finish_mail_flg',
            'entry_mail_flg',
            'exit_mail_flg'
        ];

        $allFlagsSet = true;
        foreach ($requiredFlags as $flag) {
            if ($eventprogress->where($flag, 1)->isEmpty()) {
                $allFlagsSet = false;
                break;
            }
        }

        if (!$allFlagsSet) {
            return back()->withErrors(['message' => '必要な設定が完了していません。以下の未設定の項目を設定してください。']);
        }

        return view('events.user.form', compact('eventsetting','eventbasic','event','eventsections'));

        
    }

    public function store(Request $request,Eventsetting $eventsetting , Event $event , Eventpdfimage $Eventpdfimage)
    {

        $eventpdfimage = Eventpdfimage::where('event_id', $event->id)->first();

        $eventsetting = Eventsetting::where('event_id', $event->id)->first();
        $eventbasic = Eventbasic::where('event_id', $event->id)->first();

        $eventsections = Eventsection::where('event_id', $event->id)->get();

        $rules = [
            'name' => $eventsetting->name_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
            'furigana' => $eventsetting->furigana_required_flg ? 'required|string|max:255' : 'nullable|string|max:255',
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
            'mail' => [
                'required', 
                'email', 
                'max:255', 
                function ($attribute, $value, $fail) use ($event) {
                    if (Eventuser::where('event_id', $event->id)->where('mail', $value)->exists()) {
                        $fail('このメールアドレスは既に使用されています。');
                    }
                }
            ],
            'login_id' => [
                'required', 
                'string', 
                'max:255', 
                function ($attribute, $value, $fail) use ($event) {
                    if (Eventuser::where('event_id', $event->id)->where('login_id', $value)->exists()) {
                        $fail('このログインIDは既に使用されています。');
                    }
                }
            ],
            'password' => 'required|string|min:8',
            'approval' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $uuid = (string) Str::uuid();

        $eventuser = new Eventuser();
        $eventuser->name = $request->input('name');
        $eventuser->furigana = $request->input('furigana');
        $eventuser->event_id = $event->id;
        $eventuser->company = $request->input('company');
        $eventuser->division = $request->input('division');
        $eventuser->post = $request->input('post');
        $eventuser->postal_code = $request->input('postal_code');
        $eventuser->address1 = $request->input('address1');
        $eventuser->address2 = $request->input('address2');
        $eventuser->address3 = $request->input('address3');
        $eventuser->tel = $request->input('tel');
        $eventuser->birth = $request->input('birth');
        $eventuser->section = $request->input('section');
        $eventuser->login_id = $request->input('login_id');
        $eventuser->password = bcrypt($request->input('password'));
        $eventuser->approval = $request->input('approval');
        $eventuser->mail = $request->input('mail');
        $eventuser->qr = $uuid;

        //登録完了メールを送る（e-mail認証までやりたい）

        //QRを作成してPDFに埋め込みつつできたPDFをstorageに保存する
        $appUrl = config('app.url');
        $qrCodeUrl = $appUrl . '/events/'.$event->id.'/qr/user/' . $uuid;

        $eventpdfimage_data = null;

        if ($eventpdfimage->image) {
            $eventpdfimage_data = base64_encode(Storage::get($eventpdfimage->image));
        }

        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrCodeUrl);
        $pdf = PDF::loadView('pdf.pdf', ['qrCode' => $qrCode, 'eventuser' => $eventuser , 'eventpdfimage' => $eventpdfimage_data])->setPaper('a4');
        $pdfPath = 'public/pdfs/' . $uuid . '.pdf';
        Storage::put($pdfPath, $pdf->output());

        $eventuser->pdf_name = $pdfPath;
        $eventuser->save();

        return redirect()->route('eventform.finish', ['event' => $event->id])->with('success', '登録が完了しました。');
    }


    public function showMypage(Request $request, $eventId, Eventmypagebasic $eventmypagebasic)
    {

        $eventmypagebasic = Eventmypagebasic::where('event_id', $eventId)->first();

        if (!auth()->guard('eventuser')->check() || Auth::guard('eventuser')->user()->event_id != $eventId) {
            return redirect()->route('eventuser.login', ['event' => $eventId]);
        }

        $user = Auth::guard('eventuser')->user();
        $event = Event::findOrFail($eventId);

        return view('events.user.mypage', compact('user', 'event', 'eventmypagebasic'));
    }

    public function logout(Request $request,Event $event)
    {
        Auth::guard('eventuser')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('eventuser.login', ['event' => $request->event]);
    }


}
