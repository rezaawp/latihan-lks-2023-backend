<?php

namespace App\Http\Controllers;

use App\Helpers\Formatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('islogin', ['except' => ['login', 'register']]);
    }

    public function register(Request $req)
    {
        # code...
        $data = [
            'name'          => $req['name'],
            'email'         => $req['email'],
            'password'      => bcrypt($req['password']),
            'role'          => $req['role']
        ];

        $validasi = Validator::make($req->all(), [
            'name'          => ['required', 'string', 'min:4'],
            'email'         => ['required', 'email'],
            'password'      => ['min:8'],
            'role'          => ['required', 'in:user,admin']
        ], [
            'role.in'       => "Silahkan masukan 'user' atau 'admin'"
        ]);

        if ($validasi->fails()) {
            return response()->json(Formatter::response(400, 'Validasi Errors', $validasi->errors()));
        }

        User::create($data);

        $data['password'] = null;
        return response()->json(Formatter::response(201, 'Register Berhasil', $data));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(Formatter::response(401, 'Username atau password salah'), 401);
        }

        $user = Auth::user();
        return response()->json(Formatter::response(200, 'Success Login', [
            'access_token'          => $token,
            'token_type'            => 'Bearer',
            'expired'               => env('JWT_TTL')
        ]), 200);
    }

    public function refresh()
    {
        return response()->json(Formatter::response(200, 'Refresh Success', [
            'access_token'     => Auth::refresh(),
            'type'             => 'Bearer',
            'expired'          => env('JWT_TTL')
        ]));
    }

    public function me(Request $req)
    {
        return response()->json(Formatter::response(200, 'Success', [
            'user'  => Auth::user()
        ]), 200);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(Formatter::response(200, 'Success Logout'), 200);
    }

    public function resetPassword(Request $req)
    {
        $user = Auth::user()->id;

        $validasi = Validator::make($req->all(), [
            'old_password'      => 'current_password:api',
            'new_password'      => ['required', 'min:8']
        ]);

        if ($validasi->fails()) {
            return response()->json(Formatter::response(400, 'Validasi Error', $validasi->errors()), 401);
        }

        User::find($user)->update([
            'password'      => bcrypt($req['new_password'])
        ]);

        return response()->json(Formatter::response(200, 'Password Berhasil Di Update', [
            'new_password' => bcrypt($req['new_password'])
        ]));
    }
}
