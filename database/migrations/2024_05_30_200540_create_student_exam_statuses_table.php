<?php

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
        Schema::create('student_exam_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_exam_id')->constrained()->cascadeOnDelete();
            $table->enum('status', [
                StudentExamStatusEnum::ASSIGNED_TO_EXAMINER,
                StudentExamStatusEnum::DATE_TIME_SET,
                StudentExamStatusEnum::ASSESSMENT_ADDED,
            ])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exam_statuses');
    }
};
