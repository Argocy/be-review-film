<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;




class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::get();
        return response ([
            "message" => "Tampil data berhasil",
            "data" => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate ([
            "name" => "required"
        ], [
            "required" => "Nama wajib diisi"
        ]);


        $roles = new Roles();
        $roles->name = $request->input("name");
        $roles->save();

        return response ([
            "message" => "Roles baru berhasil ditambahkan",
            "data"  => $roles
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roles = Roles::find($id);

        if(!$roles) {
            return response([
            "message" => "Detail $id tidak ditemukan",
            "data" => $roles  
            ], 401);
        }
        return response([
            "message" => "Detail Role Berhasil Ditampilkan",
            "data" => $roles
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate ([
            "name" => "required"
        ], [
            "required" => "Nama wajib diisi"
        ]);
        
        $roles = Roles::find($id);

        if(!$roles) {
            return response ([
                "message" => "detail roles tidak bisa ditemukan",
                "data" => $roles
            ], 404);
        }

        $roles->name = $request->input("name");
        $roles->save();

        return response ([
            "message" => "nama role berhasil diperbarui",
            "data"  => $roles
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roles = Roles::find($id);
        if(!$roles) {
            return response ([
                "message" => "detail role tidak bisa ditemukan",
                "data" => $roles
            ], 404);
        }
        $roles->delete();
        return response ([
            "message" => "detail role berhasil dihapus"
        ], 200);
    }
}
