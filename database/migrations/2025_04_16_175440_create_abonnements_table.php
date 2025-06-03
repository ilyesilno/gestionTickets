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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->date("date_debut");
            $table->date("date_fin");
            $table->string("status");
            $table->foreignId('produitID')->constrained('produits')->onDelete('cascade');
            $table->foreignId('slaID')->constrained('slas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('abonnements');
        Schema::enableForeignKeyConstraints();
            }
};
