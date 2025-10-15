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
        Schema::create('barra_de_blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trabajador_id');
            $table->unsignedBigInteger('id_blog');
            $table->string('titulo');
            $table->text('contenido');
            $table->integer('valoracion');
            $table->timestamps();

            $table->foreign('trabajador_id')->references('id')->on('trabajadores')->onDelete('cascade');
            $table->foreign('id_blog')->references('id')->on('blogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barra_de_blogs');
    }
};
