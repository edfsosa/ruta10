<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'tracking_number',
        'sender_id',
        'receiver_id',
        'origin_agency_id',
        'destination_agency_id',
        'service_type',
        'status',
        'pickup_address_id',
        'delivery_address_id',
        'notes',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }

    public function origin_agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'origin_agency_id');
    }

    public function destination_agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'destination_agency_id');
    }

    public function pickup_address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'pickup_address_id');
    }

    public function delivery_address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(ShipmentHistory::class);
    }

    protected static function booted()
    {
        static::creating(function ($shipment) {
            do {
                $code = 'REM' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (Shipment::where('tracking_number', $code)->exists());

            $shipment->tracking_number = $code;
        });
    }
}
