<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'deskripsi', 'pagu_bulanan'])]
class Satker extends Model
{
    use HasFactory;

    public function urs()
    {
        return $this->hasMany(Ur::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}