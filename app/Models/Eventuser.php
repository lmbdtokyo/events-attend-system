<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventuser extends Model
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
        'qr',
        'pdf_name'
    ];
}
