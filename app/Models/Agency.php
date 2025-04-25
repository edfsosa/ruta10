<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agency extends Model
{
    protected $table = 'agencies';

    protected $fillable = [
        'name',
        'address',
        'city_id',
        'phone',
        'email',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
