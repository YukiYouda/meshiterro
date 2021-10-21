<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'info',
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function getImagePathAttribute()
    {
        return 'articles/' . $this->attachments->first()->name;
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}
