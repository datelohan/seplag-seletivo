<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $primaryKey = 'pes_id'; // Define a chave primária como 'pes_id'
    public $incrementing = true; // Indica que a chave primária é auto-incrementada
    protected $keyType = 'int'; // Define o tipo da chave primária como inteiro

    protected $fillable = [
        'pes_nome',
        'pes_data_nascimento',
        'pes_sexo',
        'pes_mae',
        'pes_pai',
    ];

    public function enderecos()
    {
        return $this->hasMany(PessoaEndereco::class);
    }

    public function fotos()
    {
        return $this->hasMany(FotoPessoa::class);
    }
}
