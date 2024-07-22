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
        Schema::create('tag_note', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tags_id')->unsigned();
            $table->unsignedBigInteger('notes_id')->unsigned();
            $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('notes_id')->references('id')->on('notes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags_notes');
    }
};
