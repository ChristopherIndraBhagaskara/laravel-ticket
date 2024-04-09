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
            $table->string('number');
            $table->string('title');
            $table->enum('type', ['TASK', 'BUG']);
            $table->enum('assigned_to', ['ANGGIT', 'TRI', 'BANU']);
            $table->text('description');
            $table->enum('label', ['TO DO', 'DOING']);
            $table->enum('project', ['ECARE PHASE 2', 'ECARE PHASE 3']);
            $table->unsignedInteger('order');
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
