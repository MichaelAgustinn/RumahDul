<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['user_id', 'judul', 'mata_kuliah', 'jenis', 'file_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
