<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index()
    {
        return view('pages.team', [
            'members' => TeamMember::active()->directory()->orderBy('order')->get(),
        ]);
    }
}
