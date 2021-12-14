<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'menu_name',
        'language',
        'link_name',
        'description',
        'custom_url',
        'private',
        'order',
        'parent_id',
    ];
}
