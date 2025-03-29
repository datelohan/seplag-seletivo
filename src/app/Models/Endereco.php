<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $primaryKey = 'end_id'; // Define a chave primária como 'end_id'
    public $incrementing = true; // Indica que a chave primária é auto-incrementada
    protected $keyType = 'int'; // Define o tipo da chave primária como inteiro

    protected $fillable = [
        'end_tipo_logradouro',
        'end_logradouro',
        'end_numero',
        'cid_id',
        'created_at',
        'updated_at',
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cid_id', 'cid_id');
    }
}
