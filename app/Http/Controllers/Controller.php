<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Page;
use App\Category;
use App\Language;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    	$languages = Language::orderBy('sort_id')->get();
        $pages = Page::where('status', 1)->orderBy('sort_id')->get()->toTree();
        $categories = Category::where('status', 1)->orderBy('sort_id')->get()->toTree();

        view()->share([
            'pages' => $pages,
            'categories' => $categories,
            'languages' => $languages,
        ]);
    }
}