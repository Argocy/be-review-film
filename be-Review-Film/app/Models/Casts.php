<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
//cast 
class Casts extends Model
{
    use HasFactory,HasUuids;
    protected $table = 'casts';
    public $timestamps = true;
    protected $fillable = ['name', 'age', 'bio'];

  //table pivot cast movie
  public function cast(): BelongsToMany
  {
      return $this->belongsToMany(Casts::class, 'cast__movies', 'casts_id', 'movies_id')->withPivot('casts_id');
  }

  //table pivot 1 cast memiliki banyak movie

  public function list_movies() {
    return $this->belongsToMany(Movie::class, 'cast__movies', 'casts_id', 'movies_id') ;
  }

  //table pivot 1  movies memiliki banyak cast

/**
 * The roles that belong to the Casts
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
public function list_casts(): BelongsToMany
{
    return $this->belongsToMany(Movie::class, 'cast__movie', 'casts_id', 'movies_id');
}
}
