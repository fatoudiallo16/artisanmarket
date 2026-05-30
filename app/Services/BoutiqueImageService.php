<?php

namespace App\Services;

use App\Models\VendeurProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BoutiqueImageService
{
    public function store(UploadedFile $file, int $userId): string
    {
        $directory = "boutiques/user_{$userId}";
        $filename = 'logo-' . Str::ulid() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($directory, $filename, 'public');
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    public function replace(VendeurProfile $profile, UploadedFile $file): string
    {
        $this->delete($profile->image);

        return $this->store($file, (int) $profile->user_id);
    }
}
