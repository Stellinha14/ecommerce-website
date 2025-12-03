<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
    ];

    // Pedido pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pedido tem vários itens
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    

}
