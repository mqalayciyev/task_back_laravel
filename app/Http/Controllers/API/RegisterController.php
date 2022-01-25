<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Ad qeyd edilməyib.',
            'name.min' => 'Ad minimum 3 simvol olmalıdır.',
            'email.required'  => 'Email boş ola bilməz.',
            'email.email'  => 'Düzgün email forması daxil edin.',
            'email.unique'  => 'Bu email artıq qeydiyyatdan keçib.',
            'email.min' => 'Email minimum 5 simvol olmalıdır.',
            'password.required'  => 'Şifrə boş ola bilməz.',
            'password.min'  => 'Şifrə minimum 6 simvol omalıdır.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users|min:5',
            'password' => 'required|min:6'
        ], $messages);




        if($validator->fails()){
            return response()->json(['status' => 'warning', 'message' => $validator->errors()]);
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);


        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];


        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Giriş uğursuz oldu']);
        }

        $user = $request->user();

        $tokenRes = $user->createToken('User Logged: ' . $request->email);

        $token = $tokenRes->token;

        $expiry = Carbon::now()->addDays(1);

        $token->expires_at;

        $auth['token'] = $tokenRes->accessToken;
        $auth['expiry'] = $expiry;
        $auth['user'] = $user;
        return response()->json(['status' => 'success', 'message' => 'Uğurlu', 'authentication' => $auth], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
