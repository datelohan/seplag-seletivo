<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    use HasFactory;

    protected $primaryKey = 'lot_id'; // Certifique-se de que a chave primária está correta
    public $incrementing = true; // Indica que a chave primária é auto-incrementada
    protected $keyType = 'int'; // Define o tipo da chave primária como inteiro

    protected $fillable = [
        'pes_id',
        'unid_id',
        'lot_data_lotacao',
        'lot_data_remocao',
        'lot_portaria',
        'created_at',
        'updated_at',
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unid_id', 'uni_id'); // Relacionamento com a tabela 'unidades'
    }
}
