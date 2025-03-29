<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorTemporario extends Model
{
    use HasFactory;

    protected $fillable = [
        'pes_id',
        'ser_data_admissao',
        'ser_data_demissao',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id'); // Relacionamento correto com a tabela 'unidades'
    }
}
