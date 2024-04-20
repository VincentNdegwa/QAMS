<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('found_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('expected_result_id');
            $table->foreign('expected_result_id')->references('id')->on('expected_results')->onDelete('cascade');
            $table->text('result_description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('found_results');
    }
};
