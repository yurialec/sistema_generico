<?php

namespace App\Http\Controllers;

use App\Repositories\Site\AboutRepository;
use App\Repositories\Site\CarouselRepository;
use App\Repositories\Site\ContactRepository;
use App\Repositories\Site\SocialMediaRepository;

class SiteController extends Controller
{
    public object|null $carouselRepository;
    public object|null $aboutRepository;
    public object|null $contactRepository;
    public object|null $socialMediaRepository;

    public function __construct(
        CarouselRepository $carouselRepository,
        AboutRepository $aboutRepository,
        ContactRepository $contactRepository,
        SocialMediaRepository $socialMediaRepository
    ) {
        $this->carouselRepository = $carouselRepository;
        $this->aboutRepository = $aboutRepository;
        $this->contactRepository = $contactRepository;
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function index()
    {
        $carousels = $this->carouselRepository->all();
        $contact = $this->contactRepository->all()[0] ?? null;
        $socialmedias = $this->socialMediaRepository->all();

        return view('site', compact('carousels', 'contact', 'socialmedias'));
    }

    public function about()
    {
        $about = $this->aboutRepository->all()[0] ?? null;
        return view('partials.about.index', compact('about'));
    }

    public function contact()
    {
        $contact = $this->contactRepository->all()[0] ?? null;
        return view('partials.contact.index', compact('contact'));
    }
}
