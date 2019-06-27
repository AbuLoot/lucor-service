<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

class PromoController extends Controller
{
    public function index()
    {
        return view('promo.index');
    }

    public function epimedium()
    {
        $project = Project::where('name', 'epimedium')->first();

        return view('promo.epimedium', compact('project'));
    }

    public function collagen()
    {
        $project = Project::where('name', 'collagen')->first();
        return view('promo.collagen', compact('project'));
    }
}
