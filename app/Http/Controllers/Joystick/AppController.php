<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\App;

class AppController extends Controller
{
    public function index()
    {
    	$apps = App::orderBy('created_at', 'desc')->paginate(50);

        return view('joystick-admin.apps.index', compact('apps'));
    }

    public function show($id)
    {
        $app = App::findOrFail($id);

        return view('joystick-admin.apps.show', compact('app'));
    }

    public function destroy($id)
    {
        $app = App::find($id);
        $app->delete();

        return redirect('/admin/apps')->with('status', 'Запись удалена.');
    }
}
