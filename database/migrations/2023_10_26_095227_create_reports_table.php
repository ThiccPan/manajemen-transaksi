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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('document');
            $table->string('client_name');
            $table->string('client_domicile');
            $table->string('coordinate_url');
            $table->enum('status', ['CHECK_IN', 'CHECK_OUT']);
            $table->enum('type', ['VISIT', 'NOO', 'ORDER']);
            $table->timestamps();
            $table->timestamp('check_out_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
