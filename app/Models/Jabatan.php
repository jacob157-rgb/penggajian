<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillable = ['nama'];
    public $timestamps = false;

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
