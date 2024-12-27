<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory,HasUuids;
    protected $table = 'movies';
    public $timestamps = true;
    protected $fillable = ['title', 'summary', 'poster', 'year' , 'genres_id'];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genres::class, 'genres_id', 'id');
    }
    
    /**
     * Get all of the comments for the Movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function genres(): HasMany
    {
        return $this->hasMany(Genres::class, 'id', 'genres_id');
    }

   /**
    * Get all of the comments for the Movie
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function castmovie(): HasMany
   {
       return $this->hasMany(Cast_Movie::class, 'movies_id', 'id');
   }

   /**
    * The roles that belong to the Movie
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function list_movies(): BelongsToMany
   {
       return $this->belongsToMany(Casts::class, 'cast__movie', 'movies_id', 'casts_id')->withPivot('casts_id');
   }

   /**
    * The roles that belong to the Movie
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function list_casts(): BelongsToMany
   {
       return $this->belongsToMany(Casts::class, 'cast__movies', 'movies_id', 'casts_id');
   }
/**
 * Get all of the comments for the Movie
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function reviews(): HasMany
{
    return $this->hasMany(Reviews::class, 'movies_id', 'id');
}


  
}


