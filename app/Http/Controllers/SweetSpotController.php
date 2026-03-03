<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\SweetSpotScoringService;

class SweetSpotController extends Controller
{
    public function calculate(SweetSpotScoringService $service)
    {
        $service->calculateAll();
        return redirect()->route('dashboard.sweetspot')->with('success', 'Scoring recalculated successfully!');
    }
}
