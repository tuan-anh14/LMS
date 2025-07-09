<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_exam_id')->constrained('student_exams')->cascadeOnDelete();
            $table->unsignedBigInteger('question_id'); // Giả định sẽ có bảng questions
            $table->text('answer_text')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->float('score')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_exam_answers');
    }
}; 