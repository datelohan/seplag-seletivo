<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaEndereco extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Atualize para usar a nova chave primária 'id'
    public $incrementing = true; // Indica que a chave primária é auto-incrementada
    protected $keyType = 'int'; // Define o tipo da chave primária como inteiro

    protected $fillable = [
        'pes_id',
        'end_id',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'end_id', 'end_id');
    }
}
