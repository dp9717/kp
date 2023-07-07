<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();

            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->text('project_ary')->nullable();

            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->text('module_ary')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('module')->default(0);
            $table->unsignedBigInteger('trainer_id');
            $table->foreign('trainer_id')->references('id')->on('users');
           $table->text('trainer_ary')->nullable();

            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('centre_creations');
            $table->text('location_ary')->nullable();
           
            $table->unsignedBigInteger('state_co_ordinator_id');
            $table->foreign('state_co_ordinator_id')->references('id')->on('users');
            $table->text('state_co_ordinator_ary')->nullable();

            //$table->string('upload_file')->nullable();
            $table->text('additional_information')->nullable();
            $table->string('slug')->nullable();
            $table->integer('status')->default(1)->comment('Approval process 1 pending 2 reject 3 approve');
            
            // created user status 1
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('user_ary')->nullable();
            $table->integer('admin_first_approval')->default('0');
            // second level status 3
            $table->integer('second_level_id')->default('0');
            $table->text('second_level_ary')->nullable();
            $table->text('second_level_comment')->nullable();
            $table->date('second_level_date')->nullable();
            $table->integer('admin_second_level_approval')->default('0');

            // third level status 4
            $table->integer('third_level_id')->default('0');
            $table->text('third_level_ary')->nullable();
            $table->text('third_level_comment')->nullable();
            $table->date('third_level_date')->nullable();
            $table->integer('admin_third_level_approval')->default('0');

            // fourth level status 5
            $table->integer('fourth_level_id')->default('0');
            $table->text('fourth_level_ary')->nullable();
            $table->text('fourth_level_comment')->nullable();
            $table->date('fourth_level_date')->nullable();
            $table->integer('admin_fourth_level_approval')->default('0');

            // rejected by
            $table->integer('rejected_by_id')->default('0');
            $table->text('rejected_by_ary')->nullable();
            $table->text('rejected_by_comment')->nullable();
            $table->date('rejected_by_date')->nullable();

            $table->date('course_start_date')->nullable();
            $table->date('course_end_date')->nullable();
            $table->text('course_teacher')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
