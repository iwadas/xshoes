<?php

use App\Models\Cart;
use App\Models\User;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Tracking;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Payment::class)->nullable();
            $table->foreignIdFor(Cart::class);
            $table->foreignIdFor(Shipping::class);
            $table->foreignIdFor(Address::class);
            $table->foreignIdFor(Tracking::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
