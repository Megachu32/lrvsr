<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Optional: Only keep this if this is NOT your default .env connection
    // protected $connection = 'db_project_bwp'; 

    protected $table = 'users';

    // 1. TELL LARAVEL YOUR PRIMARY KEY
    protected $primaryKey = 'user_id';

    // 2. DEFINE WHAT CAN BE FILLED
    protected $fillable = [
        'username',       // Changed from 'name'
        'email',
        'role_id',
        'avatar_url',
        'created_at',
        'updated_at',
        'password'
    ];

    // 3. HIDE SENSITIVE DATA
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 4. OVERRIDE PASSWORD NAME
    // This tells Laravel: "When checking passwords, look at 'password_hash' column"
    // public function getAuthPassword()
    // {
    //     return $this->password_hash;
    // }

    public function roles()
    {
        return $this->hasMany(Role::class, 'role_id', 'role_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // This auto-hashes the password when saving
        ];
    }

    // 5. RELATIONSHIPS
    
    // A user can own many communities
    public function communitiesOwned()
    {
        return $this->hasMany(Community::class, 'creator_id', 'user_id');
    }

    // A user can have many posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }
}