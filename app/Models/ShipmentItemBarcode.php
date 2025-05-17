<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentItemBarcode extends Model
{
    protected $fillable = [
        'shipment_item_id',
        'barcode',
    ];

    public function item()
    {
        return $this->belongsTo(ShipmentItem::class, 'shipment_item_id');
    }
}
