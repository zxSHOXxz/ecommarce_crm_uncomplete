<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $guarded=['id','created_at','updated_at'];

    
    public function products()
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function getCategoryCover($type = "thumb")
    {
        if ($this->cover == null)
            return env('DEFAULT_IMAGE_AVATAR');
        else
            return env("STORAGE_URL") . '/' . \MainHelper::get_conversion($this->cover, $type);
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
