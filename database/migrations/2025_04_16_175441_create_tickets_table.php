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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('sujet');
            $table->text('description');
            $table->unsignedBigInteger('user_id');
            $table->string('priorite');
            $table->string('statut');
            $table->string('categorie');
            $table->unsignedBigInteger('support_level');
            $table->unsignedBigInteger('duree_qualification')->nullable();
            $table->unsignedBigInteger('duree_resolution')->nullable();
            $table->unsignedBigInteger('n1_duration')->nullable();
            $table->unsignedBigInteger('n2_duration')->nullable();
            $table->unsignedBigInteger('n3_duration')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('agents');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
