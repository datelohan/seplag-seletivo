<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPessoa extends Model
{
    use HasFactory;

    protected $fillable = [
        'fp_pes_id',
        'fp_dataa',
        'fp_bucket',
        'fp_path',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
