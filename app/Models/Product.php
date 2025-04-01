<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'code',
        'description',
        'price',
        'cost_price',
        'quantity',
        'alert_quantity',
        'image',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'status' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->alert_quantity;
    }
}
