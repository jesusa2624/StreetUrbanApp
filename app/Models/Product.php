<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'code',
        'stock',
        'image',
        'sell_price',
        'status',
        'category_id',
        'provider_id'
    ];

    // Relación con la categoría
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relación con el proveedor
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    // Relación con las tallas a través de PurchaseDetails
    public function sizes()
    {
        return $this->hasManyThrough(
            Size::class,             // Modelo destino
            PurchaseDetails::class, // Modelo intermedio
            'product_id',           // FK en PurchaseDetails que apunta a Product
            'id',                   // PK en Size
            'id',                   // PK local en Product
            'size_id'               // FK en PurchaseDetails que apunta a Size
        )->distinct(); // Para evitar tallas repetidas
    }

    // Relación con SaleDetails
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'product_id');
    }

    // Relación con PurchaseDetails
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class, 'product_id');
    }
}
