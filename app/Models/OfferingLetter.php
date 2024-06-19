<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OfferingLetter extends Model
{
    use HasFactory;

    protected $table = 'offering_letters';

    protected $guarded = ['id'];

    protected $appends = [
        'capital_return_percentage',
        'profit_margin',
        'total_price',
        'total_vat',
        'grand_total',
        'purchase_capital'
    ];

    public function offeringLetterItems(): HasMany
    {
        return $this->hasMany(OfferingLetterItem::class, 'offering_letter_id', 'id');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
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
        return $this->offeringLetterItems->sum('total_price_per_item');
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
        return $this->offeringLetterItems->sum('vendor_item_total_price');
    }
}
