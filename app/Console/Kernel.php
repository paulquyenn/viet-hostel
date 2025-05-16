<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Kiểm tra các hợp đồng hết hạn mỗi ngày lúc 00:00
        $schedule->command('app:update-expired-contracts')
            ->dailyAt('00:00')
            ->timezone('Asia/Ho_Chi_Minh');

        // Gửi thông báo cho các khoản thanh toán sắp đến hạn (3 ngày trước)
        $schedule->command('app:check-upcoming-payments --days=3')
            ->dailyAt('08:00')
            ->timezone('Asia/Ho_Chi_Minh');

        // Gửi thông báo cho các khoản thanh toán sắp đến hạn (1 ngày trước)
        $schedule->command('app:check-upcoming-payments --days=1')
            ->dailyAt('08:00')
            ->timezone('Asia/Ho_Chi_Minh');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
