<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento',
        'dataDoEvento',
        'estoque_id',
        'quantidade',
    ];

    public function estoque()
    {
        return $this->belongsTo(Estoque::class);
    }

    protected static function boot(){
        parent::boot();

        static::deleting(function($evento){
            try{
                $evento->estoque()->increment('quantidade', $evento->quantidade);
            }catch(\Exception $e){
                return false;
            }
        });
    }
}
