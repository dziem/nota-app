<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDetail extends Model
{
    use HasFactory;

    protected $table = 'price_detail';

    protected $fillable = [
        'base_price', 'stock', 'price_id'
    ];

    public function price()
    {
        return $this->belongsTo(Price::class);
    }
}
