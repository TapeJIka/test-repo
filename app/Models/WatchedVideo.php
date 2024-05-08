<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchedVideo extends Model
{
    use HasFactory;

    protected $table = 'watched_video';

    protected $fillable = [
      'user_id',
      'video_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function video() {
        return $this->belongsTo(Video::class, 'video_id');
    }
}
