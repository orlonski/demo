<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'shop_pedidos';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'total_price',
        'status',
        'currency',
        'shipping_price',
        'shipping_method',
        'notes',
    ];

    public function address(): MorphOne
    {
        return $this->morphOne(PedidoAddress::class, 'addressable');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'shop_cliente_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PedidoItem::class, 'shop_pedido_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
