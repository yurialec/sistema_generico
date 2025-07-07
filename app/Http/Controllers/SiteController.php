<?php

namespace App\Http\Controllers;

use App\Traits\SiteTrait;

class SiteController extends Controller
{
    use SiteTrait;

    public function index()
    {
        $mainText     = $this->mainText();
        $carousels    = $this->carousels();
        $contact      = $this->contactSite();
        $socialmedias = $this->socialmedias();
        $about        = $this->aboutSite();
        
        return view('site.home', compact('mainText', 'carousels', 'contact', 'socialmedias', 'about'));
    }

    public function about()
    {
        $about = $this->aboutSite();
        return view('partials.about.index', compact('about'));
    }

    public function contact()
    {
        $contact = $this->contactSite();
        return view('partials.contact.index', compact('contact'));
    }
}
