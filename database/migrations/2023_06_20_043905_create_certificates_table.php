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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->unsignedInteger('certi_heading');
            $table->string('logo1_file')->nullable();
            $table->string('logo2_file')->nullable();
            $table->string('logo3_file')->nullable();
            $table->date('issued_on')->nullable();
            $table->integer('certificate_type');
            $table->string('validity_date')->nullable();
            $table->integer('hard_copy')->default(2)->comment('1 => Yes 2 => No');
            $table->date('needed_by')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->text('vendor_ary')->nullable();
            $table->text('additional_information')->nullable();
            $table->string('name1')->nullable();
            $table->string('designation1')->nullable();
            $table->string('company1')->nullable();
            $table->string('signature1')->nullable();
            $table->string('name2')->nullable();
            $table->string('designation2')->nullable();
            $table->string('company2')->nullable();
            $table->string('signature2')->nullable();
            $table->string('name3')->nullable();
            $table->string('designation3')->nullable();
            $table->string('company3')->nullable();
            $table->string('signature3')->nullable();
            $table->integer('status')->default(1)->comment('disable for this section');

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
            $table->string('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
