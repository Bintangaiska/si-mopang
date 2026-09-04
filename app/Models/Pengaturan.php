<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        // 'logo_path',
        'foto_kabid_path',
        'nama_kabid',
        'jabatan_kabid',
    ];

    public static function current(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}