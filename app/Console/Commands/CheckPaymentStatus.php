<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Notifications\PaymentNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-payment-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra các khoản thanh toán quá hạn hoặc sắp đến hạn và gửi thông báo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Thiết lập giới hạn bộ nhớ cho PHP nếu cần
        ini_set('memory_limit', '512M');

        try {
            $this->info('Bắt đầu kiểm tra các khoản thanh toán quá hạn...');
            $this->checkOverduePayments();

            // Giải phóng bộ nhớ sau mỗi tác vụ lớn
            gc_collect_cycles();

            $this->info('Bắt đầu kiểm tra các khoản thanh toán sắp đến hạn...');
            $this->checkUpcomingPayments();

            $this->info('Đã kiểm tra xong các khoản thanh toán');
        } catch (\Exception $e) {
            $this->error('Lỗi khi kiểm tra các khoản thanh toán: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }

    /**
     * Kiểm tra các khoản thanh toán quá hạn và gửi thông báo
     */
    protected function checkOverduePayments()
    {
        $today = Carbon::today();

        // Đếm xong giải phóng bộ nhớ ngay
        $count = Payment::where('payment_status', 'pending')
            ->where('payment_date', '<', $today)
            ->count();

        $this->info("Tìm thấy {$count} khoản thanh toán quá hạn");

        // Xử lý từng hóa đơn theo ID để tiết kiệm bộ nhớ tối đa
        $paymentIds = Payment::where('payment_status', 'pending')
            ->where('payment_date', '<', $today)
            ->select('id')
            ->orderBy('id')
            ->pluck('id')
            ->toArray();

        // Xử lý từng khoản thanh toán một
        foreach ($paymentIds as $paymentId) {
            $this->processOverduePayment($paymentId);

            // Xóa bộ nhớ cache sau mỗi notification để giảm áp lực bộ nhớ
            gc_collect_cycles();
        }
    }

    /**
     * Xử lý từng khoản thanh toán quá hạn
     */
    protected function processOverduePayment($paymentId)
    {
        try {
            $payment = Payment::select(['id', 'payment_number', 'amount', 'payment_date', 'payment_period_start', 'payment_period_end', 'contract_id'])
                ->with([
                    'contract:id,tenant_id,landlord_id,room_id',
                    'contract.tenant:id,name,email',
                    'contract.landlord:id,name,email',
                    'contract.room:id,room_number'
                ])
                ->find($paymentId);

            if (!$payment) {
                return;
            }

            // Gửi thông báo cho người thuê
            if ($payment->contract && $payment->contract->tenant) {
                $payment->contract->tenant->notify(new PaymentNotification($payment, 'overdue'));
            }

            // Gửi thông báo cho chủ trọ
            if ($payment->contract && $payment->contract->landlord) {
                $payment->contract->landlord->notify(new PaymentNotification($payment, 'overdue'));
            }
        } catch (\Exception $e) {
            $this->error("Lỗi khi xử lý thanh toán ID {$paymentId}: " . $e->getMessage());
        }
    }

    /**
     * Kiểm tra các khoản thanh toán sắp đến hạn và gửi thông báo
     */
    protected function checkUpcomingPayments()
    {
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addDays(7);

        // Đếm xong giải phóng bộ nhớ ngay
        $count = Payment::where('payment_status', 'pending')
            ->whereBetween('payment_date', [$today, $nextWeek])
            ->count();

        $this->info("Tìm thấy {$count} khoản thanh toán sắp đến hạn");

        // Xử lý từng hóa đơn theo ID để tiết kiệm bộ nhớ
        $paymentIds = Payment::where('payment_status', 'pending')
            ->whereBetween('payment_date', [$today, $nextWeek])
            ->select('id')
            ->orderBy('id')
            ->pluck('id')
            ->toArray();

        // Xử lý từng khoản thanh toán một
        foreach ($paymentIds as $paymentId) {
            $this->processUpcomingPayment($paymentId);

            // Xóa bộ nhớ cache sau mỗi notification để giảm áp lực bộ nhớ
            gc_collect_cycles();
        }
    }

    /**
     * Xử lý từng khoản thanh toán sắp đến hạn
     */
    protected function processUpcomingPayment($paymentId)
    {
        try {
            $payment = Payment::select(['id', 'payment_number', 'amount', 'payment_date', 'payment_period_start', 'payment_period_end', 'contract_id'])
                ->with([
                    'contract:id,tenant_id,room_id',
                    'contract.tenant:id,name,email',
                    'contract.room:id,room_number'
                ])
                ->find($paymentId);

            if (!$payment) {
                return;
            }

            // Gửi thông báo cho người thuê
            if ($payment->contract && $payment->contract->tenant) {
                $payment->contract->tenant->notify(new PaymentNotification($payment, 'upcoming'));
            }
        } catch (\Exception $e) {
            $this->error("Lỗi khi xử lý thanh toán ID {$paymentId}: " . $e->getMessage());
        }
    }
}
