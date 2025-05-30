<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_time',
        'total_price',
        'total_item',
        'kasir_id',
        'payment_method',
        'nominal_bayar',
        'kembalian',
        'payment_status',
        'card_number',
        'card_holder',
    ];


    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
