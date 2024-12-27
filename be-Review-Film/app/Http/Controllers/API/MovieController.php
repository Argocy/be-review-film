<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Movie;

class MovieController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'isAdmin'])->except('index', 'show');
    }
    /**
     * Display a listing of the resource. no middleware
     */
    public function index()
    {
        $movie = Movie::get();
        return response ([
            "message" => "judul movie berhasil ditampilkan",
            "data" => $movie
        ]);
    }

    /**
     * Store a newly created resource in storage. or update middleware
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "summary" => "required",
            "year" => "required",
            "poster" => "image|mimes:jpeg,png,jpg,gif",
            "genres_id" => "required|exists:genres,id"
        ], [
            "required" => "Kolom ini Wajib Diisi",
            "mimes" => "Format gambar tidak benar",
            "exists" => "data movie tidak ditemukan"
        ]);


        $uploadedFileUrl = cloudinary()->upload($request->file('poster')->getRealPath(), [
            'folder' => 'poster',
        ])->getSecurePath();

        $movie = new Movie();
        $movie->title = $request->input("title");
        $movie->summary = $request->input("summary");
        $movie->year = $request->input("year");
        $movie->poster = $uploadedFileUrl;
        $movie->genres_id = $request->input("genres_id");
        $movie->save();

        return response ([
            "message" => "List movie berhasil ditambahkan",
            
        ]);
        
    }

    /**
     * Display the specified resource. detail no middleware
     */
    public function show(string $id)
    {
        $movie = Movie::with(['list_casts','reviews'])->findOrFail($id);
    

        if(!$movie){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $movie
            ], 404);
        }


        return response([
            "message" => "Detail Movie Berhasil Ditampilkan",
            "data" => $movie
        ], 200);
    }

    /**
     * Update the specified resource in storage. update middleware
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "title" => "required",
            "summary" => "required",
            "year" => "required",
            "poster" => "image|mimes:jpeg,png,jpg,gif",
            "genres_id" => "required|exists:genres,id"
        ], [
            "required" => "Kolom ini Wajib Diisi",
            "mimes" => "Format gambar tidak benar",
            "exists" => "data movie tidak ditemukan"
        ]);


        $movie = Movie::find($id);

        if($request->hasFile('poster')) {
            $uploadedFileUrl = cloudinary()->upload($request->file('poster')->getRealPath(), [
                'folder' => 'poster',
            ])->getSecurePath();
            $movie->poster = $uploadedFileUrl;
        }


        if(!$movie){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $movie
            ], 404);
        }


        $movie->title = $request->input("title");
        $movie->summary = $request->input("summary");
        $movie->year = $request->input("year");
        $movie->genres_id = $request->input("genres_id");
        $movie->save();

        return response ([
            "message" => "List movie berhasil diupdate",
            
        ]);
        
    }

    /**
     * Remove the specified resource from storage. delete middleware
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);
        if(!$movie){
            return response([
                "message" => "Detail $id tidak bisa ditemukan",
                "data" => $movie
            ], 404);
        }
        $movie->delete();

        return response([
            "message" => "Semua Data $id berhasil didelete"
        ], 200);
    }
}
