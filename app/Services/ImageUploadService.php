<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Guarda un archivo en el disco public y devuelve la ruta relativa.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */
    public function upload(UploadedFile $file, string $folder = 'images'): string
    {
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');
        return $path;
    }

    /**
     * Elimina la imagen si existe en disco.
     *
     * @param string|null $path
     * @return void
     */
    public function deleteIfExists(?string $path): void
    {
        if (!$path) return;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
