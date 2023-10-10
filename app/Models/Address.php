<?php

namespace App\Models;

use App\Models\Shop\Marca;
use App\Models\Shop\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    public function clientes()
    {
        return $this->morphedByMany(Cliente::class, 'addressable');
    }

    public function marcas()
    {
        return $this->morphedByMany(Marca::class, 'addressable');
    }
}
