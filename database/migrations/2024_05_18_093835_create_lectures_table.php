<?php

use App\Enums\LectureTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->date('date');
            $table->enum('type', [
                LectureTypeEnum::EDUCATIONAL,
                LectureTypeEnum::EDUCATIONAL_AND_TAJWEED,
                LectureTypeEnum::EDUCATIONAL_AND_UPBRINGING,
            ])->default(LectureTypeEnum::EDUCATIONAL)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
