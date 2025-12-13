<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image_path')->nullable();
            $table->string('album')->nullable();
            $table->string('file_path')->nullable();
            $table->json('tags_cache')->nullable(); // 🔹 cached IDs
            $table->foreignId('artist_id')
                ->nullable()
                ->constrained('artists')
                ->onDelete('cascade');
            $table->softDeletes(); // Adds a nullable 'deleted_at' TIMESTAMP column
            $table->timestamps();  // Adds 'created_at' and 'updated_at'

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
};
