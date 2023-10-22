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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->text('address2')->nullable();
            $table->string('city');
            $table->string('district');
            $table->string('country');
            $table->string('company')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->double('amount', 8, 2);
            $table->string('tran_id');
            $table->string('status');
            $table->string('card_type')->nullable();
            $table->string('currency')->nullable();
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
