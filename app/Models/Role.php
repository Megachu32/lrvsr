<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    
    // DISABLE TIMESTAMPS (Fixes your previous error)
    public $timestamps = false;

    protected $fillable = ['role_name', 'description'];

    // Relationship: One Role has many Users
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}