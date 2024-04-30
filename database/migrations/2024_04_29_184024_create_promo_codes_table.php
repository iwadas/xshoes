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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('discount');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->unsignedFloat('price_from')->default(0);
            $table->boolean('for_new_users')->default(false);
            $table->dateTime('available_till');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
