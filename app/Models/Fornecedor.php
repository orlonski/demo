<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'fornecedores';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
    ];

    public function itens(): HasMany
    {
        return $this->hasMany(FornecedorItem::class, 'fornecedor_id');
    }
}