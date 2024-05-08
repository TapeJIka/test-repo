<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
      'title',
      'description',
      'author_id',
      'file',
    ];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function album() {
        return $this->belongsToMany(Album::class, 'album_videos');
    }

    public function user() {
        return $this->belongsToMany(User::class, 'watched_video');
    }

    public function category() {
        return $this->belongsToMany(Category::class, 'video_categories');
    }
}
