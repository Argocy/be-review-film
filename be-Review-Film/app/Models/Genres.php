<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genres extends Model
{
    use HasFactory,HasUuids;
    protected $table = 'genres';
    public $timestamps = true;

    protected $fillable = ['name'];


    public function movie(): HasMany
    {
        return $this->hasMany(Movie::class, 'genres_id', 'id');
    }

    /**
     * Get the user that owns the Genres
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movies(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'id', 'genres_id');
    }
}
