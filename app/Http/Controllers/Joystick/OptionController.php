<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Option;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::orderBy('sort_id')->paginate(50);
        $grouped = $options->groupBy('data');

        return view('joystick-admin.options.index', compact('grouped', 'options'));
    }

    public function create()
    {
        return view('joystick-admin.options.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:options',
        ]);

        $option = new Option;

        $option->sort_id = ($request->sort_id > 0) ? $request->sort_id : $option->count() + 1;
        $option->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $option->title = $request->title;
        $option->data = $request->data;
        $option->lang = $request->lang;
        $option->save();

        return redirect('/admin/options')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $option = Option::findOrFail($id);

        return view('joystick-admin.options.edit', compact('option'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $option = Option::findOrFail($id);
        $option->sort_id = ($request->sort_id > 0) ? $request->sort_id : $option->count() + 1;
        $option->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $option->title = $request->title;
        $option->data = $request->data;
        $option->lang = $request->lang;
        $option->save();

        return redirect('/admin/options')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $option = Option::find($id);
        $option->delete();

        return redirect('/admin/options')->with('status', 'Запись удалена!');
    }
}
