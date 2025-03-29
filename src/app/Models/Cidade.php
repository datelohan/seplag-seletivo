<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $primaryKey = 'cid_id'; // Define a chave primária como 'cid_id'

    protected $fillable = [
        'cid_nome',
        'cid_uf',
        'create_at',
        'update_at',
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'cid_id', 'cid_id');
    }
}
