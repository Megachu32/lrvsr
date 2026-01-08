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
        Schema::create('votes', function (Blueprint $table) {
            $table->id('vote_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            
            // Make these nullable because you vote on EITHER a post OR a comment
            $table->foreignId('post_id')->nullable()->constrained('posts', 'post_id')->onDelete('cascade');
            $table->foreignId('comment_id')->nullable()->constrained('comments', 'comment_id')->onDelete('cascade');
            
            $table->tinyInteger('vote_type'); // 1 for Up, -1 for Down
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
