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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo', 100)->nullable();
            $table->string('favicon', 100)->nullable();
            $table->string('site_title', 100);
            $table->string('app_name', 100)->nullable();
            $table->string('about', 400);
            $table->string('phone', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
