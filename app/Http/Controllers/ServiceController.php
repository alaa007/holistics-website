<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('pages.services', [
            'services' => Service::active()->get(),
        ]);
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);

        $others = Service::active()->where('id', '!=', $service->id)->limit(4)->get();

        return view('pages.service-detail', [
            'service' => $service,
            'others' => $others,
        ]);
    }
}
