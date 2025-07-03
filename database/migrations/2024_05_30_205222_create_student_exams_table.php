<?php

use App\Enums\AssessmentEnum;
use App\Enums\StudentExamStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('examiner_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('center_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();


            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->timestamp('date_time')->nullable();

            $table->enum('status', [
                StudentExamStatusEnum::ASSIGNED_TO_EXAMINER,
                StudentExamStatusEnum::DATE_TIME_SET,
                StudentExamStatusEnum::ASSESSMENT_ADDED,
            ])->index();

            $table->enum('assessment', [
                AssessmentEnum::SUPERIORITY,
                AssessmentEnum::EXCELLENT,
                AssessmentEnum::VERY_GOOD,
                AssessmentEnum::GOOD,
                AssessmentEnum::REPEAT,
            ])->nullable()->index();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exam');
    }
};
