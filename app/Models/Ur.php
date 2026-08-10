<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['satker_id', 'nama'])]
class Ur extends Model
{
    use HasFactory;

    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}