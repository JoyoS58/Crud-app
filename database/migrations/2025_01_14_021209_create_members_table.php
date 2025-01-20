<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->foreignId('user_id')->constrained()->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->references('group_id')->on('groups')->onDelete('cascade');
            $table->date('join_date')->nullable();
            $table->string('status')->default('active');
            $table->string('role_in_group')->nullable();
            $table->unique(['user_id', 'group_id'], 'unique_user_group');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
