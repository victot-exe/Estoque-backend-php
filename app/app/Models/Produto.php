<?php
//TODO rodar todas a migrations, ainda não rodou
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'valorDeCompra',
        'valorDeVenda',
        'fornecedor_id'
    ];
}