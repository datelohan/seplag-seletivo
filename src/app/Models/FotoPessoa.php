<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPessoa extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'caminho',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
