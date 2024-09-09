<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventmypagebasic extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'endtime',
        'image',
        'title',
        'text',
    ];

}
