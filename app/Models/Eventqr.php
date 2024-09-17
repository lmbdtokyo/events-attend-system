<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventqr extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'qr_id',
        'entry_flg'
    ];
}
