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
        Schema::create('communities', function (Blueprint $table) {
            $table->id('community_id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            
            // Storing the link from the internet
            // e.g., "https://i.imgur.com/example.png"
            $table->string('icon_url')->nullable(); 
            
            $table->foreignId('creator_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
