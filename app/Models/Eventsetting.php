<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventsetting extends Model
{
    use HasFactory;

    protected $table = 'eventsetting';

    protected $fillable = [
        'event_id',
        'company_display_name',
        'company_flg',
        'company_required_flg',
        'company_placeholder',
        'division_display_name',
        'division_flg',
        'division_required_flg',
        'division_placeholder',
        'post_display_name',
        'post_flg',
        'post_required_flg',
        'post_placeholder',
        'postal_code_display_name',
        'postal_code_flg',
        'postal_code_required_flg',
        'postal_code_placeholder',
        'address1_display_name',
        'address1_flg',
        'address1_required_flg',
        'address1_placeholder',
        'address2_display_name',
        'address2_flg',
        'address2_required_flg',
        'address2_placeholder',
        'address3_display_name',
        'address3_flg',
        'address3_required_flg',
        'address3_placeholder',
        'tel_display_name',
        'tel_flg',
        'tel_required_flg',
        'tel_placeholder',
        'birth_display_name',
        'birth_flg',
        'birth_required_flg',
        'birth_placeholder',
        'section_display_name',
        'section_flg',
        'section_required_flg',
        'section_placeholder'
    ];

protected $casts = [
    'company_flg' => 'boolean',
    'company_required_flg' => 'boolean',
    'division_flg' => 'boolean',
    'division_required_flg' => 'boolean',
    'post_flg' => 'boolean',
    'post_required_flg' => 'boolean',
    'postal_code_flg' => 'boolean',
    'postal_code_required_flg' => 'boolean',
    'address1_flg' => 'boolean',
    'address1_required_flg' => 'boolean',
    'address2_flg' => 'boolean',
    'address2_required_flg' => 'boolean',
    'address3_flg' => 'boolean',
    'address3_required_flg' => 'boolean',
    'tel_flg' => 'boolean',
    'tel_required_flg' => 'boolean',
    'birth_flg' => 'boolean',
    'birth_required_flg' => 'boolean',
    'section_flg' => 'boolean',
    'section_required_flg' => 'boolean',
];

}
