<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\TeamMember;
use App\Models\ValueItem;

class AboutController extends Controller
{
    public function index()
    {
        return view('pages.about', [
            'about' => AboutContent::current(),
            'values' => ValueItem::active()->get(),
            'leadership' => TeamMember::active()->leadership()->orderBy('order')->get(),
        ]);
    }
}
