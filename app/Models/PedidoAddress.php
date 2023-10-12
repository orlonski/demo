<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PedidoAddress extends Model
{
    use HasFactory;

    protected $table = 'pedido_addresses';

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
