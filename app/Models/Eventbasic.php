<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventbasic extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'image',
        'limit',
        'limit_number',
        'start',
        'end',
        'overview_title',
        'overview_text',
        'terms',
        'privacy'
    ];
}
