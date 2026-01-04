<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalalian;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Vendor extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    public const PROFILE_IMAGE_COLLECTION = 'profile_image';

    protected $guarded = [];

    public array $translatable = [
        'name',
        'description',
    ];

    public static function defaultSupport(): array
    {
        return [
            'telegram_id' => null,
            'whatsapp' => null,
            'email' => null,
            'instagram' => null,
            'support_phone' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'commission_percent' => 'decimal:2',
            'verified_at' => 'datetime',
            'support' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::PROFILE_IMAGE_COLLECTION)->singleFile();
    }

    protected function createdAt(): Attribute
    {
        return Attribute::get(fn ($value) => $this->localizeDate($value));
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::get(fn ($value) => $this->localizeDate($value));
    }

    protected function verifiedAt(): Attribute
    {
        return Attribute::get(fn ($value) => $this->localizeDate($value));
    }

    protected function localizeDate(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        $carbon = $value instanceof CarbonInterface ? $value : $this->asDateTime($value);

        if (app()->getLocale() === 'fa') {
            return Jalalian::fromCarbon($carbon)->format('Y/m/d H:i:s');
        }

        return $carbon;
    }
}
