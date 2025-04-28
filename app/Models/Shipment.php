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
        'driver_id',
        'user_id',
        'payment_method',
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

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(ShipmentHistory::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
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

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pendiente',
            'in_transit' => 'En tránsito',
            'delivered' => 'Entregado',
            'canceled' => 'Cancelado',
            default => 'Desconocido',
        };
    }

    public function getServiceTypeLabelAttribute()
    {
        return match ($this->service_type) {
            'agency_to_agency' => 'Agencia a Agencia',
            'door_to_door' => 'Puerta a Puerta',
            'door_to_agency' => 'Puerta a Agencia',
            'agency_to_door' => 'Agencia a Puerta',
            default => 'Desconocido',
        };
    }
}
