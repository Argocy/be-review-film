<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Roles;
use App\Mail\otpMail;
use App\Mail\GenerateKodeBaru;
use App\Models\OtpCode;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed",
        ], [
            "required" => "Kolom ini Wajib Diisi",
            "min" => "Password kurang dari 8 karakter",
            "email" => "kolom ini harus diisi dengan email",
            "unique" => "email sudah terdaftar",
            "confirmed" => "password salah atau berbeda"
        ]);

        $roleUser = Roles::where('name', 'user')->first();
        $user = new User;


        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->input("password"));
        $user->role_id = $roleUser->id;
        $user->save();

        Mail::to($user->email)->send(new otpMail($user));

        return response ([
            "message" => "Register Account berhasil dilakukan,Cek email mu untuk melakukan verifikasi",
            "user" =>$user,
        ], 200);
    }

    public function login(Request $request)
    {

        $request->validate([
            "email" => "required",
            "password" => "required",
        ], [
            "required" => "Kolom ini Wajib Diisi",
        ]);

        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'password atau email salah', 
        ], 401);
        }

      

       $user = JWTAuth::user();

        return response ([
            "message" => "Login Account Berhasil",
            "user" =>$user,
            "token" => $token,
        ], 200);
    }

    public function me()
    {
        $user = auth()->user();
        return response()->json(auth()->user([
            'user' => $user
        ]));
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function generateotp(Request $request) {
        $request->validate([
            "email" => "required|email",
        ], [
            "required" => "Kolom ini Wajib Diisi",
            "email"    => "Kolom ini harus berformat email"
        ]);

            $user = User::where('email', $request->input('email'))->first();
            $user->generate_code();

            Mail::to($user->email)->send(new GenerateKodeBaru($user));

            return response()->json([
                'message' => "otp berhasil dikirim kembali"
            ]);
    }




    public function verifikasi(Request $request) {

        
        $request->validate([
            "otp" => "required",
        ], [
            "required" => "Kolom ini Wajib Diisi"
        ]);

        //mengambil data user yang login
        $user = auth()->user();
        $otp_code = OtpCode::where('otp', $request->input('otp'))->where('users_id', $user->id)->first();
        //jika otp salah 
        if(!$otp_code) {
            return response ([
                'message' => 'otp salah!'
            ], 400);
        }
        //jika otp sudah melebihi batas waktu
        $now = Carbon::now();
        if($now > $otp_code->valid_until) {
            return response ([
                "message" => "kode otp sudah tidak berlaku,lakukan verifikasi ulang untuk mendapatkan kode yang baru"
            ], 400);
        }

        //memeriksa apakah user sudah melakukan verifikasi email
        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now(); 
            $user->save();
        }

        $otp_code->delete();

        return response([
            "message" => "Anda sudah melakukan Verifikasi"
        ]);
    }
}