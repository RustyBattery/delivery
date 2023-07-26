<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->nullOnDelete();
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->foreign('courier_id')->references('id')->on('couriers')->nullOnDelete();
            $table->unsignedBigInteger('cook_id')->nullable();
            $table->foreign('cook_id')->references('id')->on('cooks')->nullOnDelete();
            $table->dateTime('delivery_time')->nullable();
            $table->dateTime('order_time')->nullable();
            $table->longText('address');
            $table->unsignedBigInteger('price')->default(0);
            $table->enum('status', ['Created', 'Kitchen', 'Packaging', 'Delivery', 'Delivered', 'Canceled'])->default('Created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
