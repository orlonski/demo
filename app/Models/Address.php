<?php

namespace App\Models;

use App\Models\Marca;
use App\Models\Cliente;
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
