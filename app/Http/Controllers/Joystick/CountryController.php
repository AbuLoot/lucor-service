<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('sort_id')->paginate(50);

        return view('joystick-admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('joystick-admin.countries.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:countries',
        ]);

        $country = new Country;

        $country->sort_id = ($request->sort_id > 0) ? $request->sort_id : $country->count() + 1;
        $country->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $country->title = $request->title;
        $country->lang = $request->lang;
        $country->status = ($request->status == 'on') ? 1 : 0;
        $country->save();

        return redirect('/admin/countries')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);

        return view('joystick-admin.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $country = Country::findOrFail($id);
        $country->sort_id = ($request->sort_id > 0) ? $request->sort_id : $country->count() + 1;
        $country->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $country->title = $request->title;
        $country->lang = $request->lang;
		$country->status = ($request->status == 'on') ? 1 : 0;
        $country->save();

        return redirect('/admin/countries')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();

        return redirect('/admin/countries')->with('status', 'Запись удалена!');
    }
}
