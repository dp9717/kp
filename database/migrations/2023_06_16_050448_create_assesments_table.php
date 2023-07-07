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
        Schema::create('assesments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
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
        Schema::dropIfExists('assesments');
    }
};
