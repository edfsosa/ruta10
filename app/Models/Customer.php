<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'ci',
        'phone',
        'email',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
