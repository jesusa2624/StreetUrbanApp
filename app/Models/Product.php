<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'stock', 'image', 'sell_price', 'status', 'category_id', 'provider_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
