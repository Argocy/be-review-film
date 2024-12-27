<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reviews;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
    
            $request->validate ([
                'critic' => "required",
                'rating' => 'required|min:1|max:5',
                'movies_id' => 'required|exists:movies,id'
            ], [
                'required' => 'kolom ini wajib diisi',
                'min' => 'Nilai minimal kurang dari 1',
                'max' => 'Nilai Maximal melebihi 5',
                'exist' => 'Data tidak diketahui masukan data yang benar'
            ]);
    
            $reviews = Reviews::updateOrCreate(
                [
                    'users_id' => $user->id, 
                    'movies_id' => $request->input('movies_id'),
                ],
                [
                    'critic' => $request->input('critic'), 
                    'rating' => $request->input('rating'), 
                ]
            );
    
            return response ([
                "message" => "Critic berhasil ditambahkan atau di update"
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
