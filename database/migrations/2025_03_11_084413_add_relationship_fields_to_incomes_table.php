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
        Schema::table('incomes', function (Blueprint $table) {
            $table->unsignedInteger('income_category_id')->nullable();

            // $table->foreign('income_category_id', 'income_category_fk_334997')->references('id')->on('income_categories');

            $table->unsignedInteger('created_by_id')->nullable();

            // $table->foreign('created_by_id', 'created_by_fk_335009')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            //
        });
    }
};
