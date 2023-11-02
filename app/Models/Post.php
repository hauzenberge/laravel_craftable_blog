<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
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
        'text_preview'
    ];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/posts/' . $this->getKey());
    }
    public function getTextPreviewAttribute()
    {
        return substr($this->description, 0, 100) . '...';
    }

    /* ************************ Relations ************************* */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_has_post', 'post_id', 'category_id');
    }
}
