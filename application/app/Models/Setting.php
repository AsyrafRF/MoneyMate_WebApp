<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional jika nama file sudah jamak/settings)
     * Namun karena kita buat migrasi 'settings', Laravel otomatis mendeteksi.
     */
    protected $table = 'settings';

    /**
     * Kolom yang boleh diisi melalui Setting::create atau Setting::updateOrCreate
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Opsional: Menonaktifkan timestamp jika Anda merasa tidak butuh data 
     * created_at dan updated_at untuk tabel pengaturan.
     */
    // public $timestamps = false;

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}