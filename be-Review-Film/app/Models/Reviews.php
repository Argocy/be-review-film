<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Reviews extends Model
{
    use HasFactory,HasUuids;
    protected $table = 'reviews';
    public $timestamps = true;

    protected $fillable = ['critic', 'rating', 'movies_id', 'users_id'];


    /**
     * Get the user that owns the Reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movies_id', 'id');
    }
}
