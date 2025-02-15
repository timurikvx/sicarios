<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function auth(Request $request)
    {
        $user = $request->get('login');
        $password = $request->get('pass');
        $users = collect(json_decode(Storage::get('user.json'), true));
        $pass = $users->get($user);
        if(is_null($pass)){
            return ['auth'=>false, 'error'=>'Пользователь не найден'];
        }

        return ['auth'=>($pass === $password)];

    }

}
