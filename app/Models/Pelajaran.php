<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasFactory;
    protected $table = 'pelajaran';
    protected $fillable = [
        'id',
        'type',
        'title',
        'content'
        
    ];
      public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'kelas_id');
    }
    public function submateri()
    {
        return $this->hasMany(SubMateri::class, 'pelajaran_id');
    }
}
