<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;

use Carbon;

class UserController extends Controller
{
    public function login(Request $request) {

        if ($request->has('username') && $request->has('password')) {

            $username = $request->username;
            $password = $request->password;

            $user = User::where('username', $username)->where('password', md5($password))->first();

            if ($user) {

                $user['auth-token'] = $this->generateRandomString(32);
                $user->save();

                return [
                    'status' => 'Success',
                    'data' => array($user)
                ];
            }

        }

        return response(
            ['status' => 'Unauthorized'],
            401
        );
    }

    public function checkToken(Request $request) {
        if ($request->has('authToken')) {
            if ($user = User::where('auth-token', $request->authToken)->first()) {
                return [
                    'status' => 'Success',
                    'data' => array($user)
                ];
            }
        }

        return response(
            ['status' => 'Unauthorized'],
            401
        );
    }

    private function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
