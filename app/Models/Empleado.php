<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;   //  IMPORTANTE: importa Storage

class Empleado extends Model
{
    //
    protected $table = 'empleados';

    protected $fillable = [
        'Nombre',
        'ApellidoPaterno',
        'ApellidoMaterno',
        'CorreoElectronico',
        'Fotografia',
    ];

    // Normaliza la ruta relativa guardada en BD (maneja backslashes de Windows)
    public function getFotoPathAttribute(): ?string
    {
        return $this->Fotografia ? str_replace('\\','/',$this->Fotografia) : null;
    }

    // ¿Existe físicamente el archivo en el disco 'public'?
    public function getTieneFotoAttribute(): bool
    {
        $path = $this->foto_path;
        return (bool) ($path && Storage::disk('public')->exists($path));
    }

    // URL pública (/storage/...) de la foto si existe, o null si no
    public function getFotoUrlAttribute(): ?string
    {
        return $this->tiene_foto ? Storage::url($this->foto_path) : null;
    }

    // Siempre devuelve algo: la foto si existe, o el placeholder
    public function getFotoUrlOrPlaceholderAttribute(): string
    {
        // Tu placeholder está en: storage/app/public/images/placeholder-avatar.png
        // => URL pública: /storage/images/placeholder-avatar.png
        return $this->foto_url ?? Storage::url('images/placeholder-avatar.png');
    }
}
