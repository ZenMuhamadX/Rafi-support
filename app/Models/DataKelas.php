<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataKelas extends Model
{
    use HasFactory;
     protected $table = 'data_kelas';
    protected $fillable = [
        'id',
        'title',
        'price',
        'image',
        'description'
    ];
    public function trainerKelas()
    {
        return $this->hasMany(KelasTrainer::class, 'kelas_id', 'id');
    }
    public function scopeNotApproved($query)
    {
        return $query->where('status', '!=', 'approved');
    }
     public function materi()
    {
        return $this->hasMany(Materi::class, 'kelas_id');
    }
    public function trainers()
    {
        return $this->belongsToMany(User::class, 'trainerkelas', 'kelas_id', 'user_id')->where('role', 'trainer');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_kelas');
    }

      public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'kelas_id');
    }
    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'kelas_id');
    }
   
}
