<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanAnggaran extends Model
{
    protected $fillable = [
        'user_id',
        'unit_kerja',
        'urusan',
        'uraian',
        'tanggal_pengajuan',
        'jumlah',
        'file_rka',
        'file_perwabku',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'date',
            'jumlah' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
