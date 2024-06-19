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

    public function offeringLetter(): BelongsTo
    {
        return $this->belongsTo(OfferingLetter::class, 'offering_letter_id', 'id');
    }
}
