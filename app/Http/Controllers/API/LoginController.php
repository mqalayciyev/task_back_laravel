<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return response()->json(['status' => 'error', 'message' => ['Yanlış sorğu']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function control(Request $request) {

        if(Auth::check()){
            $user = Auth::user();
            return response()->json(['status' => 'success', 'session' => $request->user()]);
        }
        else{
            return response()->json(['status' => 'error']);
        }
    }

    public function store(Request $request)
    {




        $messages = [
            'email.required'  => 'Email boş ola bilməz.',
            'email.email'  => 'Düzgün email formatı daxil edin.',
            'password.required'  => 'Şifrə boş ola bilməz.',
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);




        if($validator->fails()){
            return response()->json(['status' => 'warning', 'message' => $validator->errors()]);
        }





        // $user = User::where('email', request('email'))->first();
        // if(!$user){
        //     return response()->json(['status' => 'error', 'message' => 'Bu emailə uyğun istifadəçi tapılmadı.']);
        // }

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

        if(request()->has('remember')){
            $expiry = Carbon::now()->addWeeks(1);
        }
        else{
            $expiry = Carbon::now()->addDays(1);
        }

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
        return response()->json(['status' => 'error', 'message' => 'Istifadəçi tapılmadı']);
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
        return response()->json(['status' => 'error', 'message' => 'Istifadəçi tapılmadı']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy()
    {
        return response()->json(['status' => 'error', 'message' => 'Istifadəçi tapılmadı']);
    }

    public function logout (Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['status' => 'success', 'message' => 'Hesabdan uğurla çıxıldı']);
    }

}
