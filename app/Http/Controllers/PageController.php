<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;

class PageController extends Controller
{
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.page')->with('page', $page);
    }

    public function contacts()
    {
        return view('pages.contacts');
        // $page = Page::where('slug', 'kontakty')->firstOrFail();

        // return view('pages.contacts')->with('page', $page);
    }
}
