<?php

use App\Enums\GenderEnum;
use App\Enums\ReadingTypeEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('governorate_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('degree_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('student_center_id')->nullable()->constrained('centers', 'id')->cascadeOnDelete();
            $table->foreignId('student_section_id')->nullable()->constrained('sections', 'id')->cascadeOnDelete();
            $table->foreignId('student_project_id')->nullable()->constrained('projects', 'id')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('second_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('type', [
                UserTypeEnum::SUPER_ADMIN,
                UserTypeEnum::ADMIN,
                UserTypeEnum::TEACHER,
                UserTypeEnum::STUDENT,
                UserTypeEnum::CENTER_MANAGER,
                UserTypeEnum::EXAMINER,
            ])->index();
            $table->enum('reading_type', [
                ReadingTypeEnum::INDIVIDUAL,
                ReadingTypeEnum::GROUP,
            ])->nullable();
            $table->string('image')->nullable();
            $table->string('locale')->default('ar');
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', [GenderEnum::MALE, GenderEnum::FEMALE])->index();
            $table->boolean('is_examiner')->default(false);
            $table->rememberToken();
            $table->timestamp('registration_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
