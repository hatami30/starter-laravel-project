<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', [
                'pedoman_manual',
                'kebijakan_program',
                'regulasi',
                'jadwal_on_call_dan_internal_extension',
                'struktur_organisasi',
                'master_dokumen'
            ])->default('pedoman_manual');
            $table->json('file_paths');
            $table->text('description');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->constrained()->onDelete('restrict');
            $table->boolean('is_public')->default(false);
            $table->integer('version')->default(1);
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'division_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
