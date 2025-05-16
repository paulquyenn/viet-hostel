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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('landlord_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rental_request_id')->nullable()->constrained('rental_requests')->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('monthly_rent', 10, 2);
            $table->decimal('deposit', 10, 2);
            $table->integer('payment_day')->comment('Day of month when payment is due');
            $table->text('terms_and_conditions')->nullable();
            $table->enum('status', ['active', 'expired', 'terminated', 'pending'])->default('pending');
            $table->text('termination_reason')->nullable();
            $table->boolean('tenant_signed')->default(false);
            $table->boolean('landlord_signed')->default(false);
            $table->date('tenant_signed_at')->nullable();
            $table->date('landlord_signed_at')->nullable();
            $table->string('document_path')->nullable()->comment('Path to uploaded contract document');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
