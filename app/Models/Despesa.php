<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Despesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_id',
        'forma_pagamento_id',
        'data_pagamento',
        'categoria_id',
    ];

    public function formaPagamento(): BelongsTo
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class, 'cliente_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaDespesa::class, 'categoria_id');
    }
}