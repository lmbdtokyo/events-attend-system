<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class initEventDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('eventbasic')->insert([
            [
                'event_id' => 1,
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
                'event_id' => 1,
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
            'event_id' => 1,
            'draft_text' => '来場申込が完了しました。<br>24時間以内に運営者より承認された場合は登録完了メールが届きますので、その後マイページからログイン頂き来場証をダウンロードくださいませ。<br>不明点は事務局までご連絡くださいませ。',
            'finish_text' => '来場登録が完了しました。<br>以下マイページからログイン頂き来場証をダウンロードくださいませ。<br>不明点は事務局までご連絡くださいませ。',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('eventmypagebasic')->insert([
            [
                'event_id' => 1,
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
                'event_id' => 1,
                'image' => null,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('eventfinishmail')->insert([
            [
                'event_id' => 1,
                'bcc' => null,
                'title' => '来場申込が完了しました',
                'text' => '来場申込が完了しました。<br>24時間以内に運営者より承認された場合は登録完了メールが届きますので、その後マイページからログイン頂き来場証をダウンロードくださいませ。<br>不明点は事務局までご連絡くださいませ。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('evententrymail')->insert([
            [
                'event_id' => 1,
                'bcc' => null,
                'title' => 'メールタイトル',
                'text' => '本文を入力してください',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);

        DB::table('eventexitmail')->insert([
            [
                'event_id' => 1,
                'bcc' => null,
                'title' => 'メールタイトル',
                'text' => '本文を入力してください',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);


        DB::table('eventprogress')->insert([
            [
                'event_id' => 1,
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
                'event_id' => 1,
                'qa' => null,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);



    }
}
