<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\HomeSlide;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Stat;
use App\Models\WhyUsItem;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'slides' => HomeSlide::active()->get(),
            'services' => Service::active()->get(),
            'whyUs' => WhyUsItem::active()->get(),
            'stats' => Stat::active()->get(),
            'settings' => Setting::current(),
            'about' => AboutContent::current(),
        ]);
    }
}
