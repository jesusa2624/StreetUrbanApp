<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'price',
        'size_id',  // Agregar el campo para la talla
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function size()
{
    return $this->belongsTo(Size::class, 'size_id');  // Referencia clara a la columna 'size_id'
}

}

