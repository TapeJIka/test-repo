<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'video_id',
    ];

    public function album() {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function video() {
        return $this->belongsTo(Video::class, 'video_id');
    }
}
