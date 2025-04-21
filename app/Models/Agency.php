<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $table = 'agencies';

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
    ];
}
