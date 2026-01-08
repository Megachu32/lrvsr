<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'comment_id';

    protected $fillable = ['post_id', 'user_id', 'parent_comment_id', 'content'];

    // Relationship to the User who wrote it
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relationship: Replies (Children)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id', 'comment_id');
    }

    // Relationship: Parent (The comment this is replying to)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id', 'comment_id');
    }
}