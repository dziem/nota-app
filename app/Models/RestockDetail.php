<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockDetail extends Model
{
    use HasFactory;

    protected $table = 'restock_detail';

    protected $fillable = [
        'name', 'quantity', 'restock_id', 'base_price'
    ];

    public $timestamps = false;

    public function restock()
    {
        return $this->belongsTo(Restock::class);
    }
}
