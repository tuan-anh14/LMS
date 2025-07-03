<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaratrustSetupTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing teams

        Schema::table('role_user', function (Blueprint $table) {
            // Drop role foreign key and primary key
            $table->dropForeign(['role_id']);
            $table->dropPrimary(['user_id', 'role_id', 'user_type']);

            // Add center_id column
            $table->unsignedBigInteger('center_id')->nullable();

            // Create foreign keys
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('centers')
                ->onUpdate('cascade')->onDelete('cascade');

            // Create a unique key
            $table->unique(['user_id', 'role_id', 'user_type', 'center_id']);
        });

        Schema::table('permission_user', function (Blueprint $table) {
            // Drop permission foreign key and primary key
            $table->dropForeign(['permission_id']);
            $table->dropPrimary(['permission_id', 'user_id', 'user_type']);

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            // Add center_id column
            $table->unsignedBigInteger('center_id')->nullable();

            $table->foreign('center_id')->references('id')->on('centers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['user_id', 'permission_id', 'user_type', 'center_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['center_id']);
        });

        Schema::table('permission_user', function (Blueprint $table) {
            $table->dropForeign(['center_id']);
        });

        // Schema::dropIfExists('centers');
    }
}
