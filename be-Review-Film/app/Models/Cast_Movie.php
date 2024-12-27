<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

//peran
class Cast_Movie extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'cast__movies';
    public $timestamps = true;
    protected $fillable = ['name', 'movies_id', 'casts_id'];


    public function list_movies() {
        return $this->belongsTo(Movie::class, 'movies_id', 'id');
    }



    public function cast() {
        return $this->belongsTo(Casts::class, 'casts_id', 'id');
    }


}
