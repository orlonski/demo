<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FornecedorItem extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'fornecedor_itens';
}
