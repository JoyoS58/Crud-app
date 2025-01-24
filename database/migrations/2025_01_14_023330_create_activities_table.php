<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id('activity_id');
            $table->string('activity_name');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->references('group_id')->on('groups')->onDelete('cascade');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
