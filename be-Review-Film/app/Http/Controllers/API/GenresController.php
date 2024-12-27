<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genres;


class GenresController extends Controller

{
    public function __construct()
    {
        $this->middleware(['auth:api', 'isAdmin'])->except('index', 'show');
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genres::get();
        return response([
            "message" => "Genre Berhasil ditambahkan",
            "data" => $genres
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:2"
        ], [
            "required" => "Kolom ini Harus diisi",
            "min" => "Minimal karakter tidak terpenuhi"
        ]);

        $genres = new Genres();
        $genres-> name = $request->input('name');
        $genres->save();

        return response([
            "message" => "Genre berhasil Ditambahkan",
            "data" => $genres
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genres = Genres::find($id);
        $genres = Genres::with('movie')->findOrFail($id);

        if(!$genres){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $genres
            ], 404);
        }


        return response([
            "message" => "Detail genre Berhasil Ditampilkan",
            "data" => $genres
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|min:2"
        ], [
            "required" => "Kolom ini Harus diisi",
            "min" => " Minimal karakter tidak terpenuhi"
        ]);

        $genres = Genres::find($id);

        if(!$genres){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $genres
            ], 404);
        }

        $genres->name = $request->input("name");
        $genres->save();

        return response([
            "message" => "Semua Data $id berhasil diupdate"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genres = Genres::find($id);
        if(!$genres){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $genres
            ], 404);
        }
        $genres->delete();

        return response([
            "message" => "Semua Data $id berhasil didelete"
        ], 200);
    }
}
