<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

class ProductDetails extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $guarded = ['id', 'created_at', 'updated_at'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getProductPhoto($type = "thumb")
    {
        if ($this->main_photo == null)
            return env('DEFAULT_IMAGE_AVATAR');
        else
            return env("STORAGE_URL") . '/' . \MainHelper::get_conversion($this->main_photo, $type);
    }

    public function getProductJsonPhotos($type = "thumb")
    {
        if ($this->photo == null) {
            return env('DEFAULT_IMAGE_AVATAR');
        } else {
            foreach (json_decode($this->photo) as $photojSON) {
                $link = env("STORAGE_URL") . '/' . \MainHelper::get_conversion($photojSON, $type);
                $photos[] = $link;
            }
            return $photos;
        }
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('tiny')
            ->fit(Manipulations::FIT_MAX, 120, 120)
            ->width(120)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();

        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_MAX, 350, 1000)
            ->width(350)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();

        $this
            ->addMediaConversion('original')
            ->fit(Manipulations::FIT_MAX, 1200, 10000)
            ->width(1200)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();
    }
}
