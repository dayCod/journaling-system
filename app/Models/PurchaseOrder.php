<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PurchaseOrder extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'purchase_orders';

    protected $guarded = ['id'];

    protected $appends = [
        'capital_return_percentage',
        'profit_margin',
        'total_price',
        'total_vat',
        'grand_total',
        'purchase_capital'
    ];

    public function offeringLetter(): BelongsTo
    {
        return $this->belongsTo(OfferingLetter::class, 'offering_letter_id', 'id');
    }

    public function purchaseOrderItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }

    public function travelDocument(): HasOne
    {
        return $this->hasOne(TravelDocument::class, 'purchase_order_id', 'id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'purchase_order_id', 'id');
    }

    public function receipt(): HasOne
    {
        return $this->hasOne(Receipt::class, 'purchase_order_id', 'id');
    }

    public function getCapitalReturnPercentageAttribute(): string
    {
        $vendorPrice = $this->getPurchaseCapitalAttribute();
        $retailPrice = $this->getTotalPriceAttribute();

        return floor((($retailPrice - $vendorPrice) / $vendorPrice) * 100).'%';
    }

    public function getProfitMarginAttribute(): int|float
    {
        $vendorPrice = $this->getPurchaseCapitalAttribute();
        $retailPrice = $this->getTotalPriceAttribute();

        return floor($retailPrice - $vendorPrice);
    }

    public function getTotalPriceAttribute(): float|int
    {
        return $this->purchaseOrderItems->sum('sub_total');
    }

    public function getTotalVatAttribute(): float|int
    {
        return $this->getTotalPriceAttribute() * 0.11;
    }

    public function getGrandTotalAttribute(): float|int
    {
        return $this->getTotalPriceAttribute() + $this->getTotalVatAttribute();
    }

    public function getPurchaseCapitalAttribute(): float|int
    {
        return $this->purchaseOrderItems->sum('vendor_item_total_price');
    }
}
