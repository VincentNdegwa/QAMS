<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testcases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('module_name');
            $table->string('title');
            $table->integer('tester_id');
            $table->enum('status', ['Incomplete', 'Complete']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testcases');
    }
};
