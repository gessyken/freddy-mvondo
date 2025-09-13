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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('civil_act_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // e.g., 'birth_declaration', 'parent_id', 'witness_id', etc.
            $table->string('file_path');
            $table->bigInteger('file_size');
            $table->string('mime_type');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_validated')->default(false);
            $table->text('validation_notes')->nullable();
            $table->timestamps();

            $table->index(['civil_act_id', 'type']);
            $table->index('is_required');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};