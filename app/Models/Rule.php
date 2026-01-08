<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rules';
    protected $primaryKey = 'rule_id';

    protected $fillable = ['community_id', 'title', 'description'];

    // Relationship: A Rule belongs to a Community
    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id', 'community_id');
    }
}