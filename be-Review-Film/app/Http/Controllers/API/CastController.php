<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Casts;
class CastController extends Controller
{


    public function __construct() {
        $this->middleware(['auth:api', 'isAdmin'])->except('index', 'show');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $casts = Casts::get();
        return response([
            "message" => "Cast berhasil ditampilkan",
            "data" => $casts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            "name" => "required|min:2",
            "age" => "required|integer",
            "bio" => "required"
        ], [
            "required" => "Kolom ini wajib diisi",
            "min" => " Minimal karakter tidak terpenuhi"
        ]);

           
        $casts = new Casts();
        $casts-> name = $request->input('name');
        $casts-> age = $request->input('age');
        $casts-> bio = $request->input('bio');
        $casts->save();

        return response([
            "message" => "Data Cast berhasil Ditambahkan",
            "data" => $casts
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $casts = Casts::with('list_movies')->findOrFail($id);


        if(!$casts){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $casts
            ], 404);
        }


        return response([
            "message" => "Detail Cast Berhasil Ditampilkan",
            "data" => $casts
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|min:2",
            "age" => "required",
            "bio" => "required"
        ], [
            "required" => "Kolom ini wajib diisi",
            "min" => " Minimal karakter tidak terpenuhi"
        ]);

        $casts = Casts::find($id);

        if(!$casts){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $casts
            ], 400);
        }

        $casts->name = $request->input("name");
        $casts->age = $request->input("age");
        $casts->bio = $request->input("bio");
        $casts->save();

        return response([
            "message" => "Semua Data $id berhasil diupdate"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $casts = Casts::find($id);
        if(!$casts){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $casts
            ], 404);
        }
        $casts->delete();

        return response([
            "message" => "Semua Data $id berhasil didelete"
        ], 200);
    }
}
