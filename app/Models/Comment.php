<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'comment',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = [
        'resource_url',
        'user'
    ];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/comments/' . $this->getKey());
    }

    public function getUserAttribute()
    {
        return fake()->name();
    }

     /* ************************ Relations ************************* */
     public function post()
     {
         return $this->belongsTo(Post::class, 'post_id');
     }
}
