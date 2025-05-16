<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Models\Room;
use App\Notifications\ContractStatusNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiredContracts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-contracts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra và cập nhật trạng thái các hợp đồng đã hết hạn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $this->info("Checking expired contracts as of {$today->format('Y-m-d')}...");

        // Tìm tất cả các hợp đồng đang hoạt động mà đã hết hạn
        $expiredContracts = Contract::where('status', 'active')
            ->where('end_date', '<', $today)
            ->with(['room', 'tenant', 'landlord'])
            ->get();

        $this->info("Found {$expiredContracts->count()} expired contracts");

        foreach ($expiredContracts as $contract) {
            $this->info("Processing contract #{$contract->contract_number} for room #{$contract->room->room_number}");

            // Cập nhật trạng thái hợp đồng thành "expired"
            $contract->status = 'expired';
            $contract->save();

            $this->info("Contract #{$contract->contract_number} marked as expired");

            // Room status sẽ được cập nhật thông qua Contract::saved event listener trong ContractServiceProvider

            // Kiểm tra xem phòng đã được cập nhật trạng thái chưa
            $room = Room::find($contract->room_id);
            if ($room->status == 1 && !$room->contracts()->where('status', 'active')->exists()) {
                $this->warn("Room #{$room->room_number} status was not updated correctly by event listener. Updating manually...");
                $room->status = 0; // 0 = còn trống
                $room->save();
                $this->info("Room #{$room->room_number} status updated to available");
            }

            $this->info("Contract #{$contract->contract_number} processed successfully");
        }

        $this->info('Command executed successfully!');
    }
}
