<?php

namespace App\Providers;

use App\Models\Center;
use App\Models\Invoice;
use App\Models\ProviderRoute;
use App\Models\StudentExam;
use App\Models\Trip;
use App\Models\Truck;
use App\Models\TruckPrice;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('center_manager', function (User $user, Center $center) {
            return $user->isManagerInCenterId($center->id);
        });

        Gate::define('teacher_student_exam', function (User $teacher, StudentExam $studentExam) {
            return $teacher->id == $studentExam->teacher_id;
        });

        Gate::define('examiner_student_exam', function (User $teacher, StudentExam $studentExam) {
            return $teacher->hasRole('examiner') && $teacher->id == $studentExam->examiner_id;
        });
    }

}
