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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\RegistrationCompleteMail;
use App\Mail\EventuserPasswordResetMail;
use App\Models\Eventfinishmail;
use App\Models\Eventrecord;


class EventUserController extends Controller
{


    public function index(Request $request, Event $event)
    {
        $query = Eventuser::where('event_id', $event->id);

        // 承認アリのイベント場合は承認済みのみ表示
        if ($event->approval == 1) {
            $query->where('approval', 1);
        }

        if ($request->filled('search') && trim($request->search) !== '') {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('mail', 'like', "%{$search}%");
            });
        }

        $totalCount = (clone $query)->count();
        $eventUsers = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $eventSections = Eventsection::where('event_id', $event->id)->get()->keyBy('id');
        $authUser = Auth::guard('web')->user();

        return view('events.detail.user', compact('event', 'eventUsers', 'eventSections', 'totalCount', 'authUser'));
    }

    public function exportCsv(Request $request, Event $event)
    {
        $query = Eventuser::where('event_id', $event->id);

        // 承認アリのイベント場合は承認済みのみ
        if ($event->approval == 1) {
            $query->where('approval', 1);
        }

        if ($request->filled('search') && trim($request->search) !== '') {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('mail', 'like', "%{$search}%");
            });
        }

        $eventUsers = $query->orderBy('created_at', 'desc')->get();
        $eventSections = Eventsection::where('event_id', $event->id)->get()->keyBy('id');

        $filename = 'event_users_' . $event->id . '_' . date('YmdHis') . '.csv';

        $approvalLabels = [0 => '下書き', 1 => '承認済み', 2 => '却下'];

        return response()->streamDownload(function () use ($eventUsers, $eventSections, $approvalLabels) {
            $stream = fopen('php://output', 'w');

            // UTF-8 BOM（Excel等で日本語が正しく表示されるように）
            fprintf($stream, chr(0xEF) . chr(0xBB) . chr(0xBF));

            $headers = [
                'ID', '名前', 'フリガナ', '会社名', '部署', '役職', '郵便番号',
                '住所1', '住所2', '住所3', '電話番号', '生年月日',
                'メールアドレス', '受付区分', '承認ステータス', '入場フラグ',
                'QRコード', '登録日', '更新日'
            ];
            fputcsv($stream, $headers);

            foreach ($eventUsers as $eventUser) {
                $sectionName = isset($eventSections[$eventUser->section])
                    ? $eventSections[$eventUser->section]->name
                    : '-';
                $approvalLabel = $approvalLabels[$eventUser->approval] ?? '-';
                $row = [
                    $eventUser->id,
                    $eventUser->name,
                    $eventUser->furigana,
                    $eventUser->company,
                    $eventUser->division,
                    $eventUser->post,
                    $eventUser->postal_code ?? '',
                    $eventUser->address1 ?? '',
                    $eventUser->address2 ?? '',
                    $eventUser->address3 ?? '',
                    $eventUser->tel ?? '',
                    $eventUser->birth ?? '',
                    $eventUser->mail,
                    $sectionName,
                    $approvalLabel,
                    $eventUser->entry_flg ?? '',
                    $eventUser->qr ?? '',
                    \Carbon\Carbon::parse($eventUser->created_at)->format('Y-m-d H:i:s'),
                    \Carbon\Carbon::parse($eventUser->updated_at)->format('Y-m-d H:i:s'),
                ];
                fputcsv($stream, $row);
            }
            fclose($stream);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function edit(Event $event, Eventuser $eventuser)
    {
        $authUser = Auth::guard('web')->user();
        if (!$authUser || $authUser->type !== 'master') {
            abort(403, 'この操作はマスター管理者のみ実行できます。');
        }
        if ($eventuser->event_id !== (int) $event->id) {
            abort(404);
        }
        $eventsetting = Eventsetting::where('event_id', $event->id)->first();
        $eventsections = Eventsection::where('event_id', $event->id)->get();
        return view('events.detail.useredit', compact('event', 'eventuser', 'eventsetting', 'eventsections'));
    }

    public function update(Request $request, Event $event, Eventuser $eventuser)
    {
        $authUser = Auth::guard('web')->user();
        if (!$authUser || $authUser->type !== 'master') {
            abort(403, 'この操作はマスター管理者のみ実行できます。');
        }
        if ($eventuser->event_id !== $event->id) {
            abort(404);
        }
        $eventsetting = Eventsetting::where('event_id', $event->id)->first();
        $eventsections = Eventsection::where('event_id', $event->id)->get();

        $rules = [
            'name' => ($eventsetting && ($eventsetting->name_required_flg ?? false)) ? 'required|string|max:255' : 'nullable|string|max:255',
            'furigana' => ($eventsetting && ($eventsetting->furigana_required_flg ?? false)) ? 'required|string|max:255' : 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'post' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'address3' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
            'birth' => 'nullable|date',
            'section' => 'nullable|exists:eventsections,id',
            'mail' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) use ($event, $eventuser) {
                    $exists = Eventuser::where('event_id', $event->id)->where('mail', $value)->where('id', '!=', $eventuser->id)->exists();
                    if ($exists) {
                        $fail('このメールアドレスは既に使用されています。');
                    }
                }
            ],
            'approval' => 'required|in:0,1,2',
            'password' => 'nullable|string|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventuser->name = $request->input('name');
        $eventuser->furigana = $request->input('furigana');
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
        $eventuser->mail = $request->input('mail');
        $eventuser->approval = (int) $request->input('approval');
        if ($request->filled('password')) {
            $eventuser->password = bcrypt($request->input('password'));
        }
        $eventuser->save();

        return redirect()->route('event.users', $event)->with('success', '申込者情報を更新しました。');
    }

    public function records(Event $event,Eventrecord $eventrecords,Eventuser $eventuser,$exit_entry)
    {

        $eventEntries = null;
        if ($exit_entry == 1) {
            $eventEntries = $eventrecords->where('event_id', $event->id)->where('entry_exit', 1)->paginate(50);
        } else {
            $eventEntries = $eventrecords->where('event_id', $event->id)->where('entry_exit', 2)->paginate(50);
        }

        $eventUsers = $eventuser->where('event_id', $event->id)->get();

        return view('events.detail.records', ['event' => $event, 'eventEntries' => $eventEntries, 'eventUsers' => $eventUsers]);
    }

    public function finish(Event $event , Eventuser $eventu , $eventuser)
    {
        // eventfinishの内容を取得
        $eventfinish = Eventfinish::where('event_id', $event->id)->first();
        $eventu = Eventuser::findOrFail($eventuser);

        $text = $eventfinish && $eventu->approval == 0 ? $eventfinish->draft_text : $eventfinish->finish_text;

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
        $credentials = $request->only('mail', 'password');
        $credentials['event_id'] = $event;

        $eventuser = Eventuser::where('mail', $credentials['mail']) 
                              ->where('event_id', $event)
                              ->first();

        if ($eventuser) {
            
            if ($eventuser->approval == 0 || $eventuser->approval == 2) {
                return back()->withErrors([
                    'error' => 'アクセスが許可されていません。', 
                ]);
            }

            if (auth()->guard('eventuser')->attempt($credentials)) {
                return redirect()->intended("/events/{$event}/mypage");
            } else {
                return back()->withErrors([
                    'error' => 'パスワードが正しくありません。', 
                ]);
            }


            
        } else {
            
            return back()->withErrors([
                'error' => 'メールアドレスが存在しません。', 
            ]);
        }
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
        $eventuser->password = bcrypt($request->input('password'));
        $eventuser->approval = $request->input('approval');
        $eventuser->mail = $request->input('mail');
        $eventuser->qr = $uuid;

        $password = $request->input('password');

        //QRを作成してPDFに埋め込みつつできたPDFをstorageに保存する
        $appUrl = config('app.url');
        $qrCodeUrl = $appUrl . '/events/'.$event->id.'/qr/user/' . $uuid;

        $eventpdfimage_data = null;

        if ($eventpdfimage->image) {
            $eventpdfimage_data = base64_encode(Storage::get($eventpdfimage->image));
        }

        
        $eventsection = Eventsection::where('id', $eventuser->section)->first();
        if (is_null($eventsection)) {
            // nullの場合の処理
            $eventsection = new Eventsection(); 
            $eventsection->name = 'QRコード';
            $eventsection->color = '#FF0000';
        }

        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrCodeUrl);
        $pdf = PDF::loadView('pdf.pdf', ['qrCode' => $qrCode, 'eventuser' => $eventuser , 'eventpdfimage' => $eventpdfimage_data , 'eventsection' => $eventsection])->setPaper('a4');
        $pdfPath = 'public/pdfs/' . $uuid . '.pdf';
        Storage::put($pdfPath, $pdf->output());

        $eventfinishmail = Eventfinishmail::where('event_id', $event->id)->first();
        if (!$eventfinishmail) {
            return redirect()->back()->withErrors(['error' => 'イベントのメール設定が見つかりません。']);
        }

        $email = trim($eventuser->mail); // 空白をトリミング

        if (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($email)->send(new RegistrationCompleteMail($eventuser, $event, $password, $eventfinishmail));
        } else {
            \Log::info('無効なメールアドレス:', ['mail' => $email]); // ログに記録
            return redirect()->back()->withErrors(['error' => '無効なメールアドレスです。']);
        }

        $eventuser->pdf_name = $pdfPath;
        $eventuser->save();

        return redirect()->route('eventform.finish', ['event' => $event->id, 'eventuser' => $eventuser->id])->with('success', '登録が完了しました。');
    }


    public function showMypage(Request $request, $eventId, Eventmypagebasic $eventmypagebasic ,Eventuser $eventuser)
    {
        $eventuser = Auth::guard('eventuser')->user();

        $eventmypagebasic = Eventmypagebasic::where('event_id', $eventId)->first();

        if (!auth()->guard('eventuser')->check()) {
            return redirect()->route('eventuser.login', ['event' => $eventId])->withErrors(['error' => 'ログインが必要です。']);
        }

        if($eventuser->event_id != $eventId){
            return redirect()->route('eventuser.login', ['event' => $eventId])->withErrors(['error' => '登録したイベントのログインが必要です。']);
        }

        $user = Auth::guard('eventuser')->user();
        $event = Event::findOrFail($eventId);
        $eventSections = Eventsection::where('event_id', $eventId)->get()->keyBy('id');
        $eventsetting = Eventsetting::where('event_id', $eventId)->first();

        return view('events.user.mypage', compact('user', 'event', 'eventmypagebasic', 'eventSections', 'eventsetting'));
    }

    public function showMypageEdit(Request $request, $eventId)
    {
        $eventuser = Auth::guard('eventuser')->user();
        if (!$eventuser || $eventuser->event_id != $eventId) {
            return redirect()->route('eventuser.login', ['event' => $eventId])->withErrors(['error' => 'ログインが必要です。']);
        }
        $event = Event::findOrFail($eventId);
        $eventsetting = Eventsetting::where('event_id', $eventId)->first();
        $eventsections = Eventsection::where('event_id', $eventId)->get();
        return view('events.user.mypage_edit', compact('event', 'eventuser', 'eventsetting', 'eventsections'));
    }

    public function mypageUpdate(Request $request, $eventId)
    {
        $eventuser = Auth::guard('eventuser')->user();
        if (!$eventuser || $eventuser->event_id != $eventId) {
            return redirect()->route('eventuser.login', ['event' => $eventId])->withErrors(['error' => 'ログインが必要です。']);
        }
        $event = Event::findOrFail($eventId);
        $eventsetting = Eventsetting::where('event_id', $eventId)->first();

        $rules = [
            'name' => 'required|string|max:255',
            'furigana' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'post' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'address3' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
            'birth' => 'nullable|date',
            'section' => 'nullable|exists:eventsections,id',
            'mail' => [
                'required', 'email', 'max:255',
                function ($attr, $val, $fail) use ($event, $eventuser) {
                    if (Eventuser::where('event_id', $event->id)->where('mail', $val)->where('id', '!=', $eventuser->id)->exists()) {
                        $fail('このメールアドレスは既に使用されています。');
                    }
                }
            ],
            'password' => 'nullable|string|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $eventuser->name = $request->input('name');
        $eventuser->furigana = $request->input('furigana');
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
        $eventuser->mail = $request->input('mail');
        if ($request->filled('password')) {
            $eventuser->password = bcrypt($request->input('password'));
        }
        $eventuser->save();

        return redirect()->route('eventuser.mypage', ['event' => $eventId])->with('success', '登録情報を更新しました。');
    }

    public function logout(Request $request,Event $event)
    {
        Auth::guard('eventuser')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('eventuser.login', ['event' => $request->event]);
    }

    public function showForgotPasswordForm(Event $event)
    {
        return view('events.user.forgot_password', compact('event'));
    }

    public function sendPasswordResetLink(Request $request, Event $event)
    {
        $request->validate(['mail' => 'required|email']);
        $eventuser = Eventuser::where('event_id', $event->id)->where('mail', $request->mail)->where('approval', 1)->first();
        if (!$eventuser) {
            return back()->withErrors(['mail' => 'このメールアドレスは登録されていないか、承認されていません。']);
        }
        $token = Str::random(64);
        Cache::put('eventuser_pw_reset_' . $token, ['eventuser_id' => $eventuser->id, 'event_id' => $event->id], now()->addMinutes(60));
        Mail::to($eventuser->mail)->send(new EventuserPasswordResetMail($eventuser, $event, $token));
        return redirect()->route('eventuser.login', $event)->with('success', 'パスワード再設定のリンクをメールで送信しました。');
    }

    public function showResetPasswordForm(Event $event, string $token)
    {
        $data = Cache::get('eventuser_pw_reset_' . $token);
        if (!$data || ($data['event_id'] ?? null) != $event->id) {
            return redirect()->route('eventuser.login', $event)->withErrors(['error' => 'リンクの有効期限が切れています。再度お試しください。']);
        }
        return view('events.user.reset_password', compact('event', 'token'));
    }

    public function resetPassword(Request $request, Event $event, string $token)
    {
        $data = Cache::get('eventuser_pw_reset_' . $token);
        if (!$data || ($data['event_id'] ?? null) != $event->id) {
            return redirect()->route('eventuser.login', $event)->withErrors(['error' => 'リンクの有効期限が切れています。再度お試しください。']);
        }
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], ['password.confirmed' => 'パスワードが一致しません。']);
        $eventuser = Eventuser::findOrFail($data['eventuser_id']);
        $eventuser->password = bcrypt($request->password);
        $eventuser->save();
        Cache::forget('eventuser_pw_reset_' . $token);
        return redirect()->route('eventuser.login', $event)->with('success', 'パスワードを再設定しました。新しいパスワードでログインしてください。');
    }


}
