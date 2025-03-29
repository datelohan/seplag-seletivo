<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorEfetivo extends Model
{
    use HasFactory;

    protected $primaryKey = 'ser_id'; // Certifique-se de que a chave primária está correta
    public $incrementing = true; // Indica que a chave primária é auto-incrementada
    protected $keyType = 'int'; // Define o tipo da chave primária como inteiro

    protected $fillable = [
        'pes_id',
        'se_matricula',
    ];

    public function lotacao()
    {
        return $this->hasOne(Lotacao::class, 'pes_id', 'pes_id'); // Relaciona pela coluna 'pes_id'
    }

    public function foto()
    {
        return $this->belongsTo(FotoPessoa::class, 'foto_id');
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id'); // Relacionamento com a tabela 'pessoas'
    }
}
