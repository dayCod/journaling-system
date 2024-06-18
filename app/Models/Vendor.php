<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $guarded = ['id'];

    public function vendorItems(): HasMany
    {
        return $this->hasMany(VendorItem::class, 'vendor_id', 'id');
    }
}
