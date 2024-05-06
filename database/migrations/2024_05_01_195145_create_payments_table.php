<?php

use App\Models\User;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('by', ['stripe', 'paypal']);
            $table->foreignIdFor(User::class);
            $table->string('key');
            $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress');
            $table->float("price");
            $table->string('payment_source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
