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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
            $table->string('name')->nullable();
            $table->string('gst')->nullable();
            $table->string('pan')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('taluk_id');
            $table->foreign('taluk_id')->references('id')->on('taluks');
            $table->unsignedBigInteger('pincode_id');
            $table->foreign('pincode_id')->references('id')->on('pincodes');
            $table->text('full_address')->nullable();
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

            $table->text('poc')->nullable();
            $table->date('contact_from')->nullable();
            $table->date('contact_to')->nullable();
            $table->text('service')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
