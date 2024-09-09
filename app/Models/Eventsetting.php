<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventsetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'company_display_name',
        'company_flg',
        'company_placeholder',
        'division_display_name',
        'division_flg',
        'division_placeholder',
        'post_display_name',
        'post_flg',
        'post_placeholder',
        'postal_code_display_name',
        'postal_code_flg',
        'postal_code_placeholder',
        'address1_display_name',
        'address1_code_flg',
        'address1_code_placeholder',
        'address2_display_name',
        'address2_code_flg',
        'address2_code_placeholder',
        'address3_display_name',
        'address3_code_flg',
        'address3_code_placeholder',
        'tel_display_name',
        'tel_code_flg',
        'tel_code_placeholder',
        'birth_display_name',
        'birth_code_flg',
        'birth_code_placeholder',
        'section_display_name',
        'section_code_flg',
        'section_code_placeholder'
    ];
}
