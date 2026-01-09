<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            
            // This links to the roles table we just made
            // default(2) assumes role_id 2 is 'Member'
            $table->foreignId('role_id')->default(2)->constrained('roles', 'role_id');

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password'); // Store hashed password here
            $table->string('avatar_url')->nullable();
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
