<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Auth;

use App\User;
use App\Role;
use App\Profile;
use App\Http\Controllers\Controller;

class AuthCustomController extends Controller
{
    public function getLogin()
    {
        return view('pages.login-reg');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|min:8|max:80'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return redirect()->back();
        }
        else {
            return redirect()->back()->withInput()->withWarning('Не правильный логин или пароль или не подтвержден номер телефона.');
        }
    }

    protected function postRegister(Request $request)
    {
        $this->validate($request, [
            // 'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            // 'phone' => 'required|min:11|max:11|unique:users',
            'email' => 'required|email|max:255|unique:users',
            // 'sex' => 'required',
            'password' => 'required|confirmed|min:6|max:255',
            // 'rules' => 'accepted'
        ]);

        $user = new User();
        $user->name = $request->name;
        // $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($user == true) {

            $role = Role::where('name', 'user')->first();
            $user->roles()->sync($role->id);

            $profile = new Profile;
            $profile->sort_id = $user->id;
            $profile->user_id = $user->id;
            $profile->city_id = 1;
            // $profile->phone = $request->phone;
            // $profile->sex = $request['sex'];
            $profile->save();

            return redirect('/login')->withInput()->withInfo('Регистрация успешно завершина. Войдите через логин и пароль.');
        }
        else {
            return redirect()->back()->withInput()->withErrors('Неверные данные');
        }
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect('/');
    }
}
