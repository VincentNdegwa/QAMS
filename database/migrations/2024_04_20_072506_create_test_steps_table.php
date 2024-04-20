<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('testcase_id');
            $table->foreign('testcase_id')->references('id')->on('testcases')->onDelete('cascade');
            $table->text('step_description');
            $table->string('step_status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_steps');
    }
};
