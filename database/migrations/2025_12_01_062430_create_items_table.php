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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->nullable();
            $table->integer('purity_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('sku')->unique();
            $table->string('name');
            $table->decimal('price')->nullable();
            $table->decimal('making_charge')->default(0);
            $table->decimal('rate_per_gram')->default(0);
            $table->decimal('gst_percent')->default(0);
            $table->decimal('gross_weight');
            $table->decimal('net_weight');
            $table->decimal('stock_qty')->default(1);
            $table->string('image')->nullable();
            $table->enum('pstatus', ['in_stock', 'sold', 'returned'])->default('in_stock');
            $table->boolean('status')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
