<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;

class UserController extends Controller
{
	public function index()
	{
		$users = User::orderBy('created_at')->paginate(50);

		return view('joystick-admin.users.index', compact('users'));
	}

	public function edit($id)
	{
		$user = User::findOrFail($id);
		$roles = Role::all();

		return view('joystick-admin.users.edit', compact('user', 'roles'));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required|max:60',
			'email' => 'required',
		]);

		$user = User::findOrFail($id);

		$user->name = $request->name;
		$user->email = $request->email;
		$user->save();

		$user->roles()->sync($request->roles_id);

		return redirect('/admin/users')->with('status', 'Запись обновлена!');
	}
}