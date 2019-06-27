<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mode;

class ModeController extends Controller
{
    public function index()
    {
        $modes = Mode::orderBy('sort_id')->paginate(50);

        return view('joystick-admin.modes.index', compact('modes'));
    }

    public function create()
    {
        return view('joystick-admin.modes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:modes',
        ]);

        $mode = new Mode;

        $mode->sort_id = ($request->sort_id > 0) ? $request->sort_id : $mode->count() + 1;
        $mode->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $mode->title = $request->title;
        $mode->data = $request->data;
        $mode->lang = $request->lang;
        $mode->status = ($request->status == 'on') ? 1 : 0;
        $mode->save();

        return redirect('/admin/modes')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $mode = Mode::findOrFail($id);

        return view('joystick-admin.modes.edit', compact('mode'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
        ]);

        $mode = Mode::findOrFail($id);
        $mode->sort_id = ($request->sort_id > 0) ? $request->sort_id : $mode->count() + 1;
        $mode->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $mode->title = $request->title;
        $mode->data = $request->data;
        $mode->lang = $request->lang;
        $mode->status = ($request->status == 'on') ? 1 : 0;
        $mode->save();

        return redirect('/admin/modes')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $mode = Mode::find($id);
        $mode->delete();

        return redirect('/admin/modes')->with('status', 'Запись удалена!');
    }
}
