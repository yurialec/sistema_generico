<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogImages extends Model
{
    use HasFactory;
    protected $table = 'blog_images';
    protected $fillable = ['title', 'description', 'order'];

    protected $with = ['blog'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
