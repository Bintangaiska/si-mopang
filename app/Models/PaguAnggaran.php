<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaguAnggaran extends Model
{
    protected $fillable = [
        'unit_kerja',
        'pagu',
    ];

    protected function casts(): array
    {
        return [
            'pagu' => 'decimal:0',
        ];
    }

    public static function paguMap(): array
    {
        $map = static::pluck('pagu', 'unit_kerja')->all();

        foreach (config('unitkerja.pagu') as $unit => $pagu) {
            $map[$unit] = $map[$unit] ?? $pagu;
        }

        return $map;
    }

    public static function paguFor(?string $unit): int
    {
        if (! $unit) {
            return 0;
        }

        return (int) (static::where('unit_kerja', $unit)->value('pagu')
            ?? config('unitkerja.pagu')[$unit]
            ?? 0);
    }
}
