<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'type',
        'first_name',
        'last_name',
        'company_name',
        'document',
        'phone',
        'email',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    // Nombre completo
    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
