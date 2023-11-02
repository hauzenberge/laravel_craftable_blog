<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];

    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/categories/'.$this->getKey());
    }

    public static function richList()
    {
        return Category::all()
        ->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });
    }
}
