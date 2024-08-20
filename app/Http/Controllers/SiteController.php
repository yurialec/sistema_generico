<?php

namespace App\Http\Controllers;

use App\Repositories\Site\CarouselRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public $carouselRepository;

    public function __construct(CarouselRepository $carouselRepository)
    {
        $this->carouselRepository = $carouselRepository;
    }

    public function index()
    {
        $carousels = $this->carouselRepository->all();

        return view('site', compact('carousels'));
    }
}
