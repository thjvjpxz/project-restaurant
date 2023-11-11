<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'image_url'
    ];


    public function getImageURL() {
        if ($this->image_url) {
            return asset('storage/' . $this->image_url);
        }
        return asset('storage/images/default_image.jpg');
    }


    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

}
