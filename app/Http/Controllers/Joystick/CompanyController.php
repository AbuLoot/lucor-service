<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Country;

use Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('sort_id')->paginate(50);

        return view('joystick-admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $countries = Country::orderBy('sort_id')->get();

        return view('joystick-admin.companies.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:companies',
        ]);

        $company = new Company;

        if ($request->hasFile('image')) {

            $logoName = str_slug($request->title).'.'.$request->image->getClientOriginalExtension();

            $request->image->storeAs('img/companies', $logoName);
        }

        $company->sort_id = ($request->sort_id > 0) ? $request->sort_id : $company->count() + 1;
        $company->country_id = ($request->country_id > 0) ? $request->country_id : 0;
        $company->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $company->title = $request->title;
        $company->logo = (isset($logoName)) ? $logoName : 'no-image-mini.png';
        $company->about = $request->about;
        $company->phones = $request->phones;
        $company->website = $request->website;
        $company->emails = $request->emails;
        $company->address = $request->address;
        $company->lang = $request->lang;
        $company->status = ($request->status == 'on') ? 1 : 0;
        $company->save();

        return redirect('/admin/companies')->with('status', 'Запись добавлена.');
    }

    public function edit($id)
    {
        $countries = Country::orderBy('sort_id')->get();
        $company = Company::findOrFail($id);

        return view('joystick-admin.companies.edit', compact('countries', 'company'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $company = Company::findOrFail($id);

        if ($request->hasFile('image')) {

            if (file_exists($company->logo)) {
                Storage::delete($company->logo);
            }

            $logoName = str_slug($request->title).'.'.$request->image->getClientOriginalExtension();

            $request->image->storeAs('img/companies', $logoName);
        }

        $company->sort_id = ($request->sort_id > 0) ? $request->sort_id : $company->count() + 1;
        $company->country_id = ($request->country_id > 0) ? $request->country_id : 0;
        $company->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $company->title = $request->title;
        if (isset($logoName)) $company->logo = $logoName;
        $company->about = $request->about;
        $company->phones = $request->phones;
        $company->website = $request->website;
        $company->emails = $request->emails;
        $company->address = $request->address;
        $company->lang = $request->lang;
        $company->status = ($request->status == 'on') ? 1 : 0;
        $company->save();

        return redirect('/admin/companies')->with('status', 'Запись обновлена.');
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if (file_exists('img/companies/'.$company->logo)) {
            Storage::delete('img/companies/'.$company->logo);
        }

        $company->delete();

        return redirect('/admin/companies')->with('status', 'Запись удалена.');
    }
}