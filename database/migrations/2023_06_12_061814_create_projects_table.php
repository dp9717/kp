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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
            $table->string('name')->nullable();
            $table->string('duration')->nullable();
            $table->string('funded_by')->nullable();
            $table->string('mou_signed')->nullable();
            $table->date('mou_start_date')->nullable();
            $table->date('mou_end_date')->nullable();
            $table->integer('target_number')->default(0);
            $table->double('est_fund_value',10,2)->nullable();
           
            //$table->string('upload_file')->nullable();
            $table->text('additional_information')->nullable();
            $table->string('slug')->nullable();
            $table->integer('status')->default(1)->comment('Approval process 1 pending 2 reject 3 approve');
            
            // created user
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('user_ary')->nullable();
            $table->integer('admin_first_approval')->default('0');
            // second level
            $table->integer('second_level_id')->default('0');
            $table->text('second_level_ary')->nullable();
            $table->text('second_level_comment')->nullable();
            $table->date('second_level_date')->nullable();
            $table->integer('admin_second_level_approval')->default('0');
            // rejected by
            $table->integer('rejected_by_id')->default('0');
            $table->text('rejected_by_ary')->nullable();
            $table->text('rejected_by_comment')->nullable();
            $table->date('rejected_by_date')->nullable();

            //project manage
            $table->unsignedBigInteger('project_manager_id');
            $table->foreign('project_manager_id')->references('id')->on('users');
            $table->text('project_manager_ary')->nullable();
            
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
