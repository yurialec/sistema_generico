<?php

namespace App\Http\Controllers;

use App\Traits\SiteTrait;

class SiteController extends Controller
{
    use SiteTrait;

    public function index()
    {
        $mainText = $this->mainText();
        $carousels = $this->carousels();
        $contact = $this->contactSite();
        $socialmedias = $this->socialmedias();
        $about = $this->aboutSite();

        return view('site', compact('mainText', 'carousels', 'contact', 'socialmedias', 'about'));
    }

    public function about()
    {
        $about = $this->aboutSite();
        $socialmedias = $this->socialmedias();

        return view('partials.about.index', compact('about', 'socialmedias'));
    }

    public function contact()
    {
        $contact = $this->contactSite();
        $socialmedias = $this->socialmedias();

        return view('partials.contact.index', compact('contact', 'socialmedias'));
    }
}
