<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    /**
     * Get the posts for the community.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the events for the community.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
