<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Notifications\PaymentNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckUpcomingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-upcoming-payments {--days=3 : Số ngày trước khi đến hạn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra các khoản thanh toán sắp đến hạn và gửi thông báo cho người thuê';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $this->info("Checking payments due in {$days} days...");

        // Lấy ngày hiện tại và ngày đến hạn cần kiểm tra
        $today = Carbon::today();
        $dueDate = $today->copy()->addDays($days);

        // Tìm tất cả các khoản thanh toán chưa thanh toán, đến hạn sau $days ngày
        $payments = Payment::where('payment_status', 'pending')
            ->whereDate('payment_date', $dueDate)
            ->with(['contract', 'contract.tenant'])
            ->get();

        $this->info("Found {$payments->count()} upcoming payments");

        // Gửi thông báo cho người thuê
        foreach ($payments as $payment) {
            $tenant = $payment->contract->tenant;
            $tenant->notify(new PaymentNotification($payment, 'upcoming'));
            $this->info("Notification sent to {$tenant->name} for payment #{$payment->payment_number}");
        }

        // Kiểm tra các khoản thanh toán quá hạn
        $overdueDateLimit = $today->copy()->subDays(1);
        $overduePayments = Payment::where('payment_status', 'pending')
            ->whereDate('payment_date', '<', $today)
            ->whereDate('payment_date', '>=', $overdueDateLimit)
            ->with(['contract', 'contract.tenant'])
            ->get();

        $this->info("Found {$overduePayments->count()} overdue payments");

        // Gửi thông báo cho người thuê về khoản quá hạn
        foreach ($overduePayments as $payment) {
            $tenant = $payment->contract->tenant;
            $tenant->notify(new PaymentNotification($payment, 'overdue'));
            $this->info("Overdue notification sent to {$tenant->name} for payment #{$payment->payment_number}");
        }

        $this->info('Command executed successfully!');
    }
}
