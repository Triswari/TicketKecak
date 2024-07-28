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
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id_booking');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_ticket');
            $table->unsignedBigInteger('id_add')->nullable();
            $table->unsignedBigInteger('id_cms');
            $table->integer('qty_ticket')->nullable();
            $table->decimal('totalPayment_ticket', 15, 2)->nullable();
            $table->enum('paymentMethod_ticket', ['Cash', 'Card', 'GlobalTix', 'Qris', 'Transfer', 'Paid', 'Delay'])->nullable();
            $table->integer('qty_add')->nullable();
            $table->decimal('totalPayment_add', 15, 2)->nullable();
            $table->enum('paymentMethod_add', ['Cash', 'Card', 'GlobalTix', 'Qris', 'Transfer', 'Delay'])->nullable();
            $table->decimal('total_cms', 15, 2)->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Define foreign keys
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('cascade');
            $table->foreign('id_ticket')->references('id_ticket')->on('tickets')->onDelete('cascade');
            $table->foreign('id_add')->references('id_add')->on('additionals')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_cms')->references('id_cms')->on('commissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
