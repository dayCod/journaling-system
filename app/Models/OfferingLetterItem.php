<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferingLetterItem extends Model
{
    use HasFactory;

    protected $table = 'offering_letter_items';

    protected $guarded = ['id'];

    protected $appends = ['pnl', 'total_pnl', 'vendor_item_total_price'];

    public function offeringLetter(): BelongsTo
    {
        return $this->belongsTo(OfferingLetter::class, 'offering_letter_id', 'id');
    }

    public function vendorItem(): BelongsTo
    {
        return $this->belongsTo(VendorItem::class, 'vendor_item_id', 'id');
    }

    public function getPNLAttribute(): string|int|float
    {
        $calc = $this->retail_price_per_item - $this->vendorItem->price;

        return $this->retail_price_per_item > $this->vendorItem->price
            ? '+ '.number_format($calc)
            : number_format($calc);
    }

    public function getTotalPNLAttribute(): string|int|float
    {
        $totalRetailPriceItem = ($this->retail_price_per_item * $this->quantity);
        $totalVendorPrice = $this->getVendorItemTotalPriceAttribute();
        $calc = $totalRetailPriceItem - $totalVendorPrice;

        return $totalRetailPriceItem > $totalVendorPrice
            ? '+ '.number_format($calc)
            : number_format($calc);
    }

    public function getVendorItemTotalPriceAttribute(): int|float
    {
        return $this->vendorItem->price * $this->quantity;
    }
}
