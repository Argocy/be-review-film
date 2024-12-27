<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;



class ProfileController extends Controller
{
    public function profile(Request $request) {
        $user = auth()->user();
        

        $request->validate([
            "age" => "required|integer",
            "biodata" => "required",
            "address" => "required",
        ], [
            "required" => "Kolom ini Wajib Diisi",
            "integer" => "Kolom ini wajib diisi angka"
        ]);


        $profiles = Profile::updateOrCreate(
        ['users_id' => $user->id], [
            'age' => $request->input('age'),
            'biodata' => $request->input('biodata'),
            'address' => $request->input('address'),
        ]
        );


        return response ([
            "message" => "profile berhasil dibuat atau di update"
        ],200);
    }
}
