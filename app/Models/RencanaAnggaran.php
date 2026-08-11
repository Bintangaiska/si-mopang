<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaAnggaran extends Model
{
    public const BULAN = [
        'jan', 'feb', 'mar', 'apr', 'mei', 'jun',
        'jul', 'agu', 'sep', 'okt', 'nov', 'des',
    ];

    public const BULAN_LABEL = [
        'jan' => 'Jan',
        'feb' => 'Feb',
        'mar' => 'Mar',
        'apr' => 'Apr',
        'mei' => 'Mei',
        'jun' => 'Jun',
        'jul' => 'Jul',
        'agu' => 'Agu',
        'sep' => 'Sep',
        'okt' => 'Okt',
        'nov' => 'Nov',
        'des' => 'Des',
    ];

    protected $fillable = [
        'satker',
        'item',
        'pagu',
        ...self::BULAN,
    ];

    protected function casts(): array
    {
        $casts = [
            'pagu' => 'decimal:0',
        ];

        foreach (self::BULAN as $bln) {
            $casts[$bln] = 'decimal:0';
        }

        return $casts;
    }
}
