<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventprogress extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'form_basic_flg',
        'form_setting_flg',
        'mypage_basic_flg',
        'finish_mail_flg',
        'entry_mail_flg',
        'exit_mail_flg'
    ];

}
