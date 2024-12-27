<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Profile extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'profiles';
    public $timestamps = true;

    protected $fillable = ['age', 'biodata', 'address', 'users_id'];
}