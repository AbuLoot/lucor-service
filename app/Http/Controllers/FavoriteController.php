<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Product;

class FavoriteController extends Controller
{
    public function clearFavorites()
    {
        $request->session()->forget('favorites');

        return redirect('/');
    }

    public function toggleFavorite(Request $request, $id)
    {
        if ($request->session()->has('favorites')) {

            $favorites = $request->session()->get('favorites');

			if (in_array($id, $favorites['products_id'])) {
				$css_class = 'btn-outline-primary';
				unset($favorites['products_id'][$id]);
			}
			else {
				$css_class = 'btn-dark';
            	$favorites['products_id'][$id] = $id;
			}

            $count = count($favorites['products_id']);

            $request->session()->put('favorites', $favorites);

            return response()->json(['id' => $id, 'cssClass' => $css_class, 'countFavorites' => $count]);
        }

        $favorites = [];
        $favorites['products_id'][$id] = $id;

        $request->session()->put('favorites', $favorites);

        return response()->json(['id' => $id, 'cssClass' => 'btn-dark btn-compact', 'countFavorites' => 1]);
    }

    public function getFavorites(Request $request)
    {
        if ($request->session()->has('favorites')) {

            $favorites = $request->session()->get('favorites');
            $products = Product::whereIn('id', $favorites['products_id'])->get();
        }
        else {
            $products = collect();
        }

        return view('pages.favorites', compact('products'));
    }

    public function destroy($id)
    {
        $favorites = $request->session()->get('favorites');

        unset($favorites['products_id'][$id]);

        $request->session()->put('favorites', $favorites);

        return redirect('favorites');
    }
}