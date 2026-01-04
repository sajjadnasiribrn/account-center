<?php

namespace App\Filament\Resources\VendorResource\Pages;

use App\Filament\Resources\VendorResource;
use App\Models\Vendor;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateVendor extends CreateRecord
{
    protected static string $resource = VendorResource::class;

    protected function afterCreate(): void
    {
        $this->syncProfileImage();
    }

    protected function syncProfileImage(): void
    {
        $state = $this->form->getState();
        $path = Arr::first(Arr::wrap($state['profile_image'] ?? null));

        if (blank($path)) {
            return;
        }

        $this->record
            ->addMediaFromDisk($path, 'public')
            ->toMediaCollection(Vendor::PROFILE_IMAGE_COLLECTION);
    }
}
