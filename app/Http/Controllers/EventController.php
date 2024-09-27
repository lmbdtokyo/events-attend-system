<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Usersorganization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Eventgenerateqr;
use App\Models\Eventpdfimage;
use App\Models\Eventfinish;
use App\Models\Eventfinishmail;
use App\Models\Evententrymail;
use App\Models\Eventexitmail;
use App\Models\Eventprogress;
use App\Models\Eventsurvey;
use App\Models\Eventsection;
use App\Models\Eventmypagebasic;
use App\Models\Eventsetting;
use App\Models\Eventqr;
use DateTime;

class EventController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->type === 'master') {
                $events = Event::orderBy('created_at', 'desc')->paginate(10);
            } else {
                $events = Event::where('organization', Auth::user()->organization)->orderBy('created_at', 'desc')->paginate(10);
            }
        } else {
            return redirect()->route('login');
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

        $lastInsertedId = Event::latest()->first()->id;

        //ここでイベントの初期データをインポート
        //seederもついでに追加
        DB::table('eventbasic')->insert([
            [
                'event_id' => $lastInsertedId,
                'title' => 'テストイベント申込フォーム',
                'image' => null,
                'limit' => false,
                'limit_number' => null,
                'start' => now()->setMinutes(0)->setSeconds(0),
                'end' => now()->addDays(31)->setMinutes(0)->setSeconds(0),
                'overview_title' => 'イベント開催概要',
                'overview_text' => '開催概要の詳細が入ります。開催概要の詳細が入ります。開催概要の詳細が入ります。開催概要の詳細が入ります。開催概要の詳細が入ります。開催概要の詳細が入ります。',
                'terms' => '利用規約の内容が入ります。',
                'privacy' => '個人情報の取り扱いについてが入ります。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('eventsetting')->insert([
            [
                'event_id' => $lastInsertedId,
                'name_display_name' => 'お名前',
                'name_flg' => 1,
                'name_required_flg' => 1,
                'name_placeholder' => null,
                'furigana_display_name' => 'フリガナ',
                'furigana_flg' => 1,
                'furigana_required_flg' => 1,
                'furigana_placeholder' => null,
                'company_display_name' => '会社名',
                'company_flg' => 1,
                'company_required_flg' => 0,
                'company_placeholder' => null,
                'division_display_name' => '部署名',
                'division_flg' => 1,
                'division_required_flg' => 0,
                'division_placeholder' => null,
                'post_display_name' => '役職',
                'post_flg' => 1,
                'post_required_flg' => 0,
                'post_placeholder' => null,
                'postal_code_display_name' => '郵便番号',
                'postal_code_flg' => 1,
                'postal_code_required_flg' => 0,
                'postal_code_placeholder' => null,
                'address1_display_name' => '住所１（都道府県）',
                'address1_flg' => 1,
                'address1_required_flg' => 0,
                'address1_placeholder' => null,
                'address2_display_name' => '住所２（市区町村）',
                'address2_flg' => 1,
                'address2_required_flg' => 0,
                'address2_placeholder' => null,
                'address3_display_name' => '住所３（番地、ビル、アパート名）',
                'address3_flg' => 1,
                'address3_required_flg' => 0,
                'address3_placeholder' => null,
                'tel_display_name' => 'お電話番号',
                'tel_flg' => 1,
                'tel_required_flg' => 0,
                'tel_placeholder' => null,
                'birth_display_name' => '生年月日',
                'birth_flg' => 1,
                'birth_required_flg' => 0,
                'birth_placeholder' => null,
                'section_display_name' => '受付区分',
                'section_flg' => 0,
                'section_required_flg' => 0,
                'section_placeholder' => null,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ]);

        DB::table('eventfinish')->insert([
            [
            'event_id' => $lastInsertedId,
            'draft_text' => '来場申込が完了しました。<br>24時間以内に運営者より承認された場合は登録完了メールが届きますので、その後マイページからログイン頂き来場証をダウンロードくださいませ。<br>不明点は事務局までご連絡くださいませ。',
            'finish_text' => '来場登録が完了しました。<br>以下マイページからログイン頂き来場証をダウンロードくださいませ。<br>不明点は事務局までご連絡くださいませ。',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('eventmypagebasic')->insert([
            [
                'event_id' => $lastInsertedId,
                'endtime' => null,
                'image' => null,
                'title' => 'お知らせ',
                'text' => 'こちらは来場登録情報です。以下来場PDFをダウンロード、印刷して会場へお持ちください。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('eventpdfimage')->insert([
            [
                'event_id' => $lastInsertedId,
                'image' => null,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        if ($request->approval == 1) {
            DB::table('eventfinishmail')->insert([
                [
                    'event_id' => $lastInsertedId,
                    'bcc' => null,
                    'title' => '来場申込が完了しました',
                    'text' => '来場申込が完了しました。<br>24時間以内に運営者より承認された場合は登録完了メールが届きますので、その後マイページからログイン頂き来場証をダウンロードくださいませ。<br>不明点は事務局までご連絡くださいませ。',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ]
            ]);
        } else {
            DB::table('eventfinishmail')->insert([
                [
                    'event_id' => $lastInsertedId,
                    'bcc' => null,
                    'title' => '来場登録が完了しました',
                    'text' => '来場登録が完了しました。<br>マイページからログイン頂き来場証をダウンロードくださいませ。<br>不明点は事務局までご連絡くださいませ。',
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ]
            ]);
        }

        DB::table('evententrymail')->insert([
            [
                'event_id' => $lastInsertedId,
                'bcc' => null,
                'title' => 'メールタイトル',
                'text' => '本文を入力してください',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('eventexitmail')->insert([
            [
                'event_id' => $lastInsertedId,
                'bcc' => null,
                'title' => 'メールタイトル',
                'text' => '本文を入力してください',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);


        DB::table('eventprogress')->insert([
            [
                'event_id' => $lastInsertedId,
                'form_basic_flg' => 0,
                'form_setting_flg' => 0,
                'mypage_basic_flg' => 0,
                'finish_mail_flg' => 0,
                'entry_mail_flg' => 1,
                'exit_mail_flg' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);


        DB::table('eventsurvey')->insert([
            [
                'event_id' => $lastInsertedId,
                'qa' => null,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        return redirect()->route('events.index')->with('success', 'イベントを作成しました。');
    }

    public function show(Event $event)
    {

        $eventProgressData = Eventprogress::where('event_id', $event->id)->get();

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        if (Auth::user()->type === 'master') {
            return view('events.show', compact('event','eventProgressData'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                return view('events.show', compact('event','eventProgressData'));
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }
    }

    public function edit(Event $event)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        if (Auth::user()->type === 'master') {
            return view('events.edit', compact('event'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                return view('events.edit', compact('event'));
            } else {
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
