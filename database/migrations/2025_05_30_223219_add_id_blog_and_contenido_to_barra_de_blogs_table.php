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
        Schema::table('barra_de_blogs', function (Blueprint $table) {
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barra_de_blogs', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['id_blog']);
            
            // Then drop the columns
            $table->dropColumn(['id_blog', 'contenido']);
        });
    }
};
