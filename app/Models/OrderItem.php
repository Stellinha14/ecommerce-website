<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'p/filme_id',
        'quantity',
        'price',
    ];

    // Item pertence a um pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item pertence a um produto
    public function filme()
    {
        return $this->belongsTo(Filme::class);
    }
}
