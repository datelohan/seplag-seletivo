<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $primaryKey = 'uni_id'; // Define a chave primária como 'uni_id'
    public $incrementing = true; // Indica que a chave primária é auto-incrementada
    protected $keyType = 'int'; // Define o tipo da chave primária como inteiro

    protected $fillable = [
        'uni_sigla',
        'uni_nome',
        'created_at',
        'updated_at',
    ];
}
