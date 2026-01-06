<?php

namespace App\Filament\Resources\VendorResource\Pages;

use App\Filament\Resources\VendorResource;
use App\Models\Vendor;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditVendor extends EditRecord
{
    protected static string $resource = VendorResource::class;

    protected function afterSave(): void
    {
        $this->syncProfileImage();
    }

    protected function syncProfileImage(): void
    {
        $state = $this->form->getRawState();
        $path = Arr::first(Arr::wrap($state['profile_image'] ?? null));
        $path = is_string($path) ? ltrim($path, '/') : $path;

        if (blank($path) || ! str_starts_with($path, 'vendors/profile/')) {
            return;
        }

        $media = $this->record
            ->addMediaFromDisk($path, 'public')
            ->toMediaCollection(Vendor::PROFILE_IMAGE_COLLECTION);

        $this->form->fill([
            'profile_image' => [$media->getPathRelativeToRoot()],
        ]);
    }
}
