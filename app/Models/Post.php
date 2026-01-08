<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // 1. Tell Laravel your custom Primary Key
    protected $primaryKey = 'post_id';

    // 2. Allow mass-filling these fields
    protected $fillable = ['user_id', 'community_id', 'title', 'content'];

    // 3. Define Relationships (The Magic)
    
    // A Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // A Post belongs to a Community
    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id', 'community_id');
    }

    // A Post has many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }
}