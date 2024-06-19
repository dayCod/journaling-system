<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OfferingLetter extends Model
{
    use HasFactory;

    protected $table = 'offering_letters';

    protected $guarded = ['id'];

    public function offeringLetterItems(): HasMany
    {
        return $this->hasMany(OfferingLetterItem::class, 'offering_letter_id', 'id');
    }
}
