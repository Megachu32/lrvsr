<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $table = 'communities';

    // 1. PRIMARY KEY
    protected $primaryKey = 'community_id';

    // 2. FILLABLE FIELDS
    protected $fillable = [
        'name',
        'description',
        'creator_id'
    ];

    // 3. RELATIONSHIPS

    // The "Creator" of the community (Link to User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'user_id');
    }

    // A Community has many Posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'community_id', 'community_id');
    }

    // A Community has many Rules
    public function rules()
    {
        return $this->hasMany(Rule::class, 'community_id', 'community_id');
    }

    // A Community has many Subscribers (Users)
    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'community_id', 'user_id');
    }
}