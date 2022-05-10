<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'price';

    use HasFactory;

    protected $fillable = [
        'name', 'base_price', 'normal_price', 'bulk_price', 'bulk_price_too', 'special_price', 'stock'
    ];

    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(PriceDetail::class, 'price_id', 'id');
    }
}
