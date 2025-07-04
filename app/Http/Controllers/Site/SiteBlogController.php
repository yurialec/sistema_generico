<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use App\Traits\SiteTrait;

class SiteBlogController extends Controller
{
    use SiteTrait;

    public function index()
    {
        $socialmedias = $this->socialmedias();
        $blogs = $this->blogs();
        return view('blog.index', compact('socialmedias', 'blogs'));
    }

    public function post(Blog $blog)
    {
        return view('blog.post', compact('blog'));
    }
}
