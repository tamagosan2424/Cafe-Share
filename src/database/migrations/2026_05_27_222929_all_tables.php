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
        Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('nickname');
        $table->text('bio',300)->nullable();
        $table->string('image');
        });

        Schema::create('cafes', function (Blueprint $table){
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('address');
        $table->string('phone_number');
        $table->string('opening_at');
        $table->string('closing_at');
        });

        Schema::create('cafes', function (Blueprint $table){
        $table->id();
        $table->foreignId('cafe_id')->constrained();
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('price');
        $table->string('image');
        });

        Schema::create('menus', function (Blueprint $table){
        $table->id();
        $table->foreignId('cafe_id')->constrained();
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('price');
        $table->string('image');
        });

        Schema::create('reviews', function (Blueprint $table){
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->foreignId('cafe_id')->constrained();
        $table->integer('rating');
        $table->text('comment')->nullable();
        });

        Schema::create('cafe_tag', function (Blueprint $table){
        $table->id();
        $table->foreignId('tag_id')->constrained();
        $table->foreignId('cafe_id')->constrained();
        });

        Schema::create('tags', function (Blueprint $table){
        $table->id();
        $table->string('name')
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafes');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('cafe_tag');
        Schema::dropIfExists('tags');
    }
};
