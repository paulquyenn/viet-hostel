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
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->string('payment_number')->unique(); // Số thanh toán (để tra cứu)
            $table->decimal('amount', 12, 0); // Số tiền thanh toán
            $table->date('payment_date'); // Ngày thanh toán
            $table->date('payment_period_start'); // Kỳ thanh toán bắt đầu
            $table->date('payment_period_end'); // Kỳ thanh toán kết thúc
            $table->string('payment_method')->nullable(); // Phương thức thanh toán (tiền mặt, chuyển khoản, v.v.)
            $table->string('payment_status')->default('pending'); // Trạng thái: pending, paid, overdue
            $table->text('notes')->nullable(); // Ghi chú bổ sung
            $table->timestamp('paid_at')->nullable(); // Thời gian thực tế thanh toán
            $table->foreignId('created_by')->constrained('users'); // Người tạo (thường là chủ trọ)
            $table->foreignId('paid_by')->nullable()->constrained('users'); // Người thanh toán (thường là người thuê)
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
