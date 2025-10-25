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
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('barra_de_blogs', 'id_blog')) {
                $table->unsignedBigInteger('id_blog')->nullable()->after('trabajador_id');
                
                // Add foreign key constraint only if column was added
                $table->foreign('id_blog')
                      ->references('id')
                      ->on('blogs')
                      ->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('barra_de_blogs', 'contenido')) {
                $table->text('contenido')->nullable()->after('titulo');
            }
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barra_de_blogs', function (Blueprint $table) {
            // Drop columns if they exist (foreign keys will be dropped automatically)
            if (Schema::hasColumn('barra_de_blogs', 'id_blog')) {
                $table->dropColumn('id_blog');
            }
            
            if (Schema::hasColumn('barra_de_blogs', 'contenido')) {
                $table->dropColumn('contenido');
            }
        });
    }
};
