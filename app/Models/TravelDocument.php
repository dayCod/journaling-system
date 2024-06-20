<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelDocument extends Model
{
    use HasFactory;

    protected $table = 'travel_documents';

    protected $guarded = ['id'];
}
