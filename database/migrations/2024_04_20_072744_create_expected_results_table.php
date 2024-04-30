<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expected_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_step_id');
            $table->foreign('test_step_id')->references('id')->on('test_steps')->onDelete('cascade');
            $table->text('result_description');
            $table->text('found_description')->nullable();
            $table->enum("pass", ["true", "false"]);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expected_results');
    }
};
