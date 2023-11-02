<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;

class Post extends Model implements HasMedia
{
    use HasFactory;   

    protected $table = 'post';

    protected $fillable = [
        'title',
        'description',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = [
        'resource_url',
        'text_preview',
        'img'
    ];

    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post_image')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/posts/' . $this->getKey());
    }
    public function getTextPreviewAttribute()
    {
        return substr($this->description, 0, 100) . '...';
    }

    public function getImgAttribute()
    {
        $media =$this->getMedia('post_image');
        if ($media->count() != 0) {
           // dd();
          // dd([0]->getUrl());
            return $media[0]->getUrl();
        }else {
            return asset('media/1/avatar.png');
        }
        
    }

    /* ************************ Relations ************************* */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_has_post', 'post_id', 'category_id');
    }
}
