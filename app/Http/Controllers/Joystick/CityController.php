<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\Country;

class CityController extends Controller
{
    public function index()
    {
    	$countries = Country::orderBy('sort_id')->get();
        $cities = City::orderBy('sort_id')->get();

        return view('joystick-admin.cities.index', compact('cities', 'countries'));
    }

    public function create()
    {
    	$countries = Country::orderBy('sort_id')->get();

        return view('joystick-admin.cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:cities',
        ]);

        $city = new City;

        $city->sort_id = ($request->sort_id > 0) ? $request->sort_id : $city->count() + 1;
        $city->country_id = $request->country_id;
        $city->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $city->title = $request->title;
        $city->lang = $request->lang;
        $city->save();

        return redirect('/admin/cities')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
    	$countries = Country::orderBy('sort_id')->get();
        $city = City::findOrFail($id);

        return view('joystick-admin.cities.edit', compact('city', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $city = City::findOrFail($id);
        $city->sort_id = ($request->sort_id > 0) ? $request->sort_id : $city->count() + 1;
        $city->country_id = $request->country_id;
        $city->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $city->title = $request->title;
        $city->lang = $request->lang;
        $city->save();

        return redirect('/admin/cities')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();

        return redirect('/admin/cities')->with('status', 'Запись удалена!');
    }
}

