<?php

namespace App\Http\ViewComposers;

use App\Traits\SiteTrait;
use Illuminate\View\View;

class FooterComposer
{
    use SiteTrait;

    public function compose(View $view)
    {
        $socialmedias = $this->socialmedias();
        $contact = $this->contactSite();

        $view->with('config', [$socialmedias, $contact]);
    }
}
