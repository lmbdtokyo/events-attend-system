<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventfinish extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'draft_text',
        'finish_text',
    ];

}
