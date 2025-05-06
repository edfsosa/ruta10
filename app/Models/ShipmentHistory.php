<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentHistory extends Model
{
    protected $table = 'shipment_histories';

    protected $fillable = [
        'shipment_id',
        'status',
        'changed_by',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
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
    
    public function getChangedByNameAttribute()
    {
        return $this->user ? $this->user->name : 'Desconocido';
    }
}
