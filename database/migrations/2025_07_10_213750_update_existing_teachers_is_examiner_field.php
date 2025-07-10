<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Enums\UserTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cập nhật trường is_examiner cho các teacher hiện có
        $teachersWithExaminerRole = User::whereHas('roles', function($query) {
            $query->where('name', UserTypeEnum::EXAMINER);
        })->get();

        foreach ($teachersWithExaminerRole as $teacher) {
            $teacher->update(['is_examiner' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Không cần rollback vì đây là dữ liệu cập nhật
    }
};
