<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    use HasFactory;

    protected $table = 'restock';

    protected $fillable = [
        'name', 'created_at'
    ];

    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(RestockDetail::class, 'restock_id', 'id');
    }
}
