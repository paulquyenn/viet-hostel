<?php

namespace App\Providers;

use App\Models\Contract;
use App\Models\Room;
use App\Notifications\ContractStatusNotification;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Khi một hợp đồng được tạo hoặc cập nhật
        Contract::saved(function ($contract) {
            $room = Room::findOrFail($contract->room_id);
            // Nếu hợp đồng trở thành active, cập nhật trạng thái phòng thành "đã thuê"
            if ($contract->status === 'active' && $contract->wasChanged('status')) {
                $room->status = 1; // 1 = đã thuê
                $room->save();

                // Gửi thông báo cho cả người thuê và chủ trọ
                $contract->tenant->notify(new \App\Notifications\ContractStatusNotification($contract, 'activated', 'Hợp đồng đã có hiệu lực'));
                $contract->landlord->notify(new \App\Notifications\ContractStatusNotification($contract, 'activated', 'Hợp đồng đã có hiệu lực'));
            }

            // Nếu hợp đồng hết hiệu lực (hết hạn hoặc bị chấm dứt)
            if (in_array($contract->status, ['expired', 'terminated']) && $contract->wasChanged('status')) {
                // Kiểm tra xem còn hợp đồng active nào khác cho phòng này không
                if (!$room->contracts()->where('id', '!=', $contract->id)->where('status', 'active')->exists()) {
                    $room->status = 0; // 0 = còn trống
                    $room->save();
                }

                // Gửi thông báo cho cả người thuê và chủ trọ
                $statusMessage = $contract->status === 'expired' ? 'Hợp đồng đã hết hạn' : 'Hợp đồng đã bị chấm dứt';
                $statusChange = $contract->status === 'expired' ? 'expired' : 'terminated';

                $contract->tenant->notify(new \App\Notifications\ContractStatusNotification($contract, $statusChange, $statusMessage));
                $contract->landlord->notify(new \App\Notifications\ContractStatusNotification($contract, $statusChange, $statusMessage));
            }
        });

        // Khi một hợp đồng bị xóa
        Contract::deleted(function ($contract) {
            $room = Room::find($contract->room_id);
            if ($room && $contract->status === 'active') {
                // Chỉ cập nhật nếu không còn hợp đồng active nào khác
                if (!$room->contracts()->where('status', 'active')->exists()) {
                    $room->status = 0; // 0 = còn trống
                    $room->save();
                }
            }
        });
    }
}
