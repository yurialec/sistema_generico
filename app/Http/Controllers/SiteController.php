<?php

namespace App\Http\Controllers;

use App\Repositories\Site\AboutRepository;
use App\Repositories\Site\CarouselRepository;

class SiteController extends Controller
{
    public object|null $carouselRepository;
    public object|null $aboutRepository;

    public function __construct(CarouselRepository $carouselRepository, AboutRepository $aboutRepository)
    {
        $this->carouselRepository = $carouselRepository;
        $this->aboutRepository = $aboutRepository;
    }

    public function index()
    {
        $carousels = $this->carouselRepository->all();

        return view('site', compact('carousels'));
    }

    public function about()
    {
        $about = $this->aboutRepository->all()[0];
        return view('partials.about.index', compact('about'));
    }
}
