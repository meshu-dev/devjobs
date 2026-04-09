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
        Schema::create('job_sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
        });

        Schema::create('job_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_site_id');
            $table->string('job_id');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('employer');
            $table->string('location');
            $table->integer('min_salary');
            $table->integer('max_salary');
            $table->string('url');
            $table->boolean('favourited')->default(false);
            $table->json('params');
            $table->date('posted_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('job_site_id')->references('id')->on('job_sites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_sites');
        Schema::dropIfExists('job_roles');
    }
};
