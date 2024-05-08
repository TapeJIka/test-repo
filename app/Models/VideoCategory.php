<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'category_id',
    ];

    public function video() {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
