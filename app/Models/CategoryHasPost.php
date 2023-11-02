<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class CategoryHasPost extends Model
{
    protected $table = 'category_has_post';

    protected $fillable = [
        'post_id',
        'category_id',

    ];


    protected $dates = [];
    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/category-has-posts/' . $this->getKey());
    }

    /* ************************ Relations ************************* */

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function getPostCategories($post_id)
    {
        return CategoryHasPost::where('post_id', $post_id)
            ->with('categories')
            ->get()
            ->map(function ($item) {
                //dd($item->categories);
                return [
                    'id' => $item->categories->id,
                    'name' => $item->categories->name
                ];
            });
    }
}
