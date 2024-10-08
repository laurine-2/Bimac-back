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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['team_id']); // Supprimer la contrainte de clé étrangère
            $table->dropColumn('team_id'); // Supprimer la colonne team_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade'); // Ajouter à nouveau la colonne et la contrainte
        });
    }
};
