<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_items';

    protected $guarded = ['id'];

    protected $appends = ['pnl', 'total_pnl', 'vendor_item_total_price'];

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function offeringLetterItem(): BelongsTo
    {
        return $this->belongsTo(OfferingLetterItem::class, 'offering_letter_item_id', 'id');
    }

    public function getPNLAttribute(): string|int|float
    {
        $calc = $this->unit_price - $this->offeringLetterItem->vendorItem->price;

        return $this->unit_price > $this->offeringLetterItem->vendorItem->price
            ? '+ '.number_format($calc)
            : number_format($calc);
    }

    public function getTotalPNLAttribute(): string|int|float
    {
        $totalUnitPrice = ($this->unit_price * $this->quantity);
        $totalVendorPrice = $this->getVendorItemTotalPriceAttribute();
        $calc = $totalUnitPrice - $totalVendorPrice;

        return $totalUnitPrice > $totalVendorPrice
            ? '+ '.number_format($calc)
            : number_format($calc);
    }

    public function getVendorItemTotalPriceAttribute(): int|float
    {
        return $this->offeringLetterItem->vendorItem->price * $this->quantity;
    }
}
