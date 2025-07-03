<?php

use App\Enums\AssessmentEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('student_lecture_id')->constrained()->cascadeOnDelete();
            $table->integer('from');
            $table->integer('to');
            $table->enum('assessment', AssessmentEnum::getConstants())->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
