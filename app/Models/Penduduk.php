<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';
    protected $fillable = ['nik', 'nama', 'kabupaten_id', 'umur', 'alamat'];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}
