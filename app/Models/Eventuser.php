<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Eventuser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'event_id',
        'furigana',
        'company',
        'division',
        'post',
        'mail',
        'postal_code',
        'address1',
        'address2',
        'address3',
        'tel',
        'birth',
        'section',
        'login_id',
        'password',
        'approval',
        'entry_flg',
        'qr',
        'pdf_name'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
