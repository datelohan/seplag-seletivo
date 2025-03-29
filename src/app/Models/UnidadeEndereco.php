<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeEndereco extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Define a chave primária como 'id'
    public $incrementing = true; // Indica que a chave primária é auto-incrementada
    protected $keyType = 'int'; // Define o tipo da chave primária como inteiro
    protected $table = 'unidade_endereco'; // Nome correto da tabela

    protected $fillable = [
        'unid_id',
        'end_id',
        'created_at',
        'updated_at',
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unid_id', 'uni_id'); // Relacionamento correto com a tabela 'unidades'
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'end_id', 'end_id'); // Relacionamento correto com a tabela 'enderecos'
    }
}
