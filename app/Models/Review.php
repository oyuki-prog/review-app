<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getFirstImagePathAttribute()
    {
        return 'reviews/' . $this->images->first()->name;
    }

    public function getFirstImageUrlAttribute()
    {
        return Storage::url($this->first_image_path);
    }
}
