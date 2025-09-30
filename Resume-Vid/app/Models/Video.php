<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
    'title', 'filename', 'transcription', 'summary', 'description', 'video_url',  // URL (optional)

];


}
