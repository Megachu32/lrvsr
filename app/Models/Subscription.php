<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';
    protected $primaryKey = 'subscription_id';
    
    // We only need created_at (joined_at), but Laravel expects updated_at too.
    // If you didn't add updated_at in migration, set this to false. 
    // Based on my code earlier, we only added 'joined_at', so:
    public $timestamps = false; 

    protected $fillable = ['user_id', 'community_id', 'joined_at'];

    // Relationship: Who is the subscriber?
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relationship: Which community?
    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id', 'community_id');
    }
}