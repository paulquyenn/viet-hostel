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
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->comment('User ID của người thuê')->constrained('users')->onDelete('cascade');
            $table->foreignId('landlord_id')->comment('User ID của chủ trọ')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('monthly_rent', 12, 0);
            $table->decimal('deposit_amount', 12, 0);
            $table->text('terms_and_conditions');
            $table->enum('status', ['active', 'expired', 'terminated', 'pending'])->default('pending');
            $table->string('file_path')->nullable()->comment('Đường dẫn đến file hợp đồng đã ký');
            $table->timestamp('signed_at')->nullable();
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
