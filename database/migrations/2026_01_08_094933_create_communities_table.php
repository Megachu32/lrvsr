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
            $table->string('name')->unique(); // e.g. 'r/Tech'
            $table->text('description')->nullable();
            
            // This links to the user who created it
            // onDelete('cascade') means if User is deleted, the Community is deleted too
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
