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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Product title
            $table->text('description'); // Product description
            $table->decimal('price', 10, 2); // Product price
            $table->string('location'); // Product location
            $table->unsignedBigInteger('subcategory_id');  // Foreign key referencing subcategories
            $table->unsignedBigInteger('user_id'); // Foreign key for users table
            $table->enum('status', ['available', 'sold'])->default('available'); // Status: available/sold
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
