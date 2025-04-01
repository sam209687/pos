<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'payment_method_id',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'final_amount',
        'paid_amount',
        'change_amount',
        'sale_date',
        'sale_time',
        'notes',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'sale_date' => 'date',
        'sale_time' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
