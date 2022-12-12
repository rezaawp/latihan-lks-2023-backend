<?php

namespace App\Http\Controllers;

use App\Helpers\Formatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $req)
    {
        # code...
        $data = [
            'name'          => $req['name'],
            'email'         => $req['email'],
            'password'      => bcrypt($req['password'])
        ];

        // return response()->json(['result' => $data]);

        $validasi = Validator::make($req->all(), [
            'name'          => ['required', 'string', 'min:4'],
            'email'         => ['required', 'email'],
            'password'      => ['min:8']
        ]);

        if ($validasi->fails()) {
            return response()->json(Formatter::response(400, 'Validasi Errors', $validasi->errors()));
        }

        User::create($data);
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
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function tes()
    {
        # code...
        return response()->json(['data' => 'data rahasia']);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
