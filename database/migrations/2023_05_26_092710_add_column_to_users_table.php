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
        Schema::table('users', function (Blueprint $table) {
            $table->string('office_no')->nullable();
            $table->string('office_email')->nullable();
            $table->string('pan_file')->nullable();
            $table->string('aadhar_file')->nullable();
            $table->string('designation')->nullable();
            $table->text('additional_information')->nullable();
            $table->string('slug')->nullable();
            $table->integer('status')->default(1)->comment('1 is active 2 inactive');

            $table->string('resume_file')->nullable();
            $table->string('other_file')->nullable();

            $table->integer('qualification')->default(1);
            $table->integer('profession')->default(1);
            $table->text('token_key')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('office_no','office_email','pan_file','aadhar_file','designation','additional_information','slug','status','resume_file','other_file','qualification','profession');
        });
    }
};
