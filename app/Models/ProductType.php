<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    protected $table = 'product_types';

    protected $fillable = [
        'name',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
