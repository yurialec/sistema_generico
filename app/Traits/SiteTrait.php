<?php

namespace App\Traits;

use App\Models\Site\MainText;
use App\Models\Site\SiteAbout;
use App\Models\Site\SiteCarousel;
use App\Models\Site\SiteContact;
use App\Models\Site\SiteSocialMedia;

trait SiteTrait
{
    public function mainText()
    {
        return MainText::first();
    }

    public function carousels()
    {
        return SiteCarousel::get();
    }

    public function contactSite()
    {
        return SiteContact::first();
    }

    public function socialmedias()
    {
        return SiteSocialMedia::get();
    }

    public function aboutSite()
    {
        return SiteAbout::first();
    }
}
