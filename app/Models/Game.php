<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title',
        'release_year',
        'genre_id',
        'platform_id'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function userGames()
    {
        return $this->hasMany(UserGame::class);
    }
}