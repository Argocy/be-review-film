<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cast_Movie;
use App\Models\Casts;
use App\Models\Movie;


class CastmovieController extends Controller
{

    public function __construct() {
        $this->middleware(['auth:api', 'isAdmin'])->except('index','show');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $castmovies = Cast_Movie::get();
        return response ([
            'message' => "Berhasil Menampilkan Cast Movie",
            "data" => $castmovies
        ]);
    }

    /**
     * Store a newly created resource in storage. admin
     */
    public function store(Request $request)
    {
        $request->validate ([
            "name" => "required",
            "casts_id" => "required",
            "movies_id" => "required"
        ], [
            "required" => "kolom wajib diisi!!"
        ]);


        

        $castmovies = new Cast_Movie();

        $castmovies-> name = $request->input('name');
        $castmovies-> casts_id =  $request->get('casts_id');
        $castmovies-> movies_id = $request->get('movies_id');
        $castmovies-> save();

        return response ([
            "message" => "Cast baru berhasil ditambahkan"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $castmovies = Cast_Movie::with(['list_movies', 'cast'])->findOrFail($id);
        
       

        if(!$castmovies) {
            return response ([
                "message" => "detail cast tidak ada",
                
            ], 404);
        }

        
        return response ([
            "message" => "Detail Cast berhasil ditampilkan",
            "data" => $castmovies
        ]);

    }

    /**
     * Update the specified resource in storage. admin
     */
    public function update(Request $request, string $id)
    {
        $request->validate ([
            "name" => "required",
        ], [
            "required" => "kolom wajib diisi!!"
        ]);


        $castmovies = Cast_Movie::find($id);

        if(!$castmovies) {
            return response ([
                "message" => "detail cast tidak ada",
                
            ], 404);
        }
        
        $castmovies-> name = $request->input('name');
        $castmovies-> casts_id = $request->input('casts_id');
        $castmovies-> movies_id = $request->input('movies_id');
        $castmovies-> save();

        return response ([
            "message" => "Cast  berhasil diupdate"
        ]);
    }

    /**
     * Remove the specified resource from storage. peran
     */
    public function destroy(string $id)
    {
        $castmovies = Cast_Movie::find($id);

        if(!$castmovies) {
            return response([
                "message" => "Detail Cast tidak ditemukan",
                "data" => $castmovies
            ], 404);
        }

        $castmovies->delete();
        return response([
            "message" => "Cast berhasil dihapus"
        ]);
    }
}
