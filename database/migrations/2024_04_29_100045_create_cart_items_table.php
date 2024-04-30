<?php

use App\Models\Cart;
use App\Models\Item;
use App\Models\Size;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cart::class)->onDelete('cascade');
            $table->foreignIdFor(Item::class)->onDelete('cascade');
            $table->foreignIdFor(Size::class)->onDelete('cascade');
            $table->unsignedInteger('amount')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
