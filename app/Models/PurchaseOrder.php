<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_orders';

    protected $guarded = ['id'];

    public function offeringLetter(): BelongsTo
    {
        return $this->belongsTo(OfferingLetter::class, 'offering_letter_id', 'id');
    }
}
