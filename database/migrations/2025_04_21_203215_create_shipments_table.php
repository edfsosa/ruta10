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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number', 20)->unique();
            $table->foreignId('sender_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('origin_agency_id')->constrained('agencies')->nullable()->onDelete('cascade');
            $table->foreignId('destination_agency_id')->constrained('agencies')->nullable()->onDelete('cascade');
            $table->enum('service_type', ['agency_to_agency', 'door_to_door', 'agency_to_door', 'door_to_agency']);
            $table->enum('status', ['pending', 'in_transit', 'delivered', 'cancelled'])->default('pending');
            $table->foreignId('pickup_address_id')->nullable()->constrained('addresses')->onDelete('cascade');
            $table->foreignId('delivery_address_id')->nullable()->constrained('addresses')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
