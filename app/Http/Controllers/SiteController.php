<?php

namespace App\Http\Controllers;

use App\Repositories\Site\AboutRepository;
use App\Repositories\Site\CarouselRepository;
use App\Repositories\Site\ContactRepository;

class SiteController extends Controller
{
    public object|null $carouselRepository;
    public object|null $aboutRepository;
    public object|null $contactRepository;

    public function __construct(CarouselRepository $carouselRepository, AboutRepository $aboutRepository, ContactRepository $contactRepository)
    {
        $this->carouselRepository = $carouselRepository;
        $this->aboutRepository = $aboutRepository;
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        $carousels = $this->carouselRepository->all();
        $contact = $this->contactRepository->all()[0] ?? null;

        return view('site', compact('carousels', 'contact'));
    }

    public function about()
    {
        $about = $this->aboutRepository->all()[0] ?? null;
        return view('partials.about.index', compact('about'));
    }

    public function contact()
    {
        return view('partials.contact.index');
    }
}
