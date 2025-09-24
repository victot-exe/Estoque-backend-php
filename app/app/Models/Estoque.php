<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'valorDeCompra',
        'valorDeVenda',
        'validade',
        'quantidade',
    ];

    protected $casts = [
        'validade' => 'date:Y-m-d',
        'valorDeCompra' => 'decimal:2',
        'valorDeVenda'  => 'decimal:2',
        'quantidade'    => 'integer',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

}