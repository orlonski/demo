<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PedidoAddress extends Model
{
    use HasFactory;

    protected $table = 'shop_pedido_addresses';

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
