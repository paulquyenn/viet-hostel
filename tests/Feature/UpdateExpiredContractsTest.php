<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateExpiredContractsTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_updates_expired_contracts()
    {
        // Tạo người dùng cho cả người thuê và chủ trọ
        $tenant = User::factory()->create(['role' => 'tenant']);
        $landlord = User::factory()->create(['role' => 'landlord']);

        // Tạo phòng trọ
        $room = Room::factory()->create([
            'status' => 1, // Đã thuê
        ]);

        // Tạo hợp đồng đã hết hạn
        $expiredContract = Contract::factory()->create([
            'room_id' => $room->id,
            'tenant_id' => $tenant->id,
            'landlord_id' => $landlord->id,
            'start_date' => Carbon::now()->subMonths(2),
            'end_date' => Carbon::now()->subDays(1), // Hợp đồng hết hạn ngày hôm qua
            'status' => 'active',
            'tenant_signed' => true,
            'landlord_signed' => true,
        ]);

        // Tạo hợp đồng còn hiệu lực
        $activeContract = Contract::factory()->create([
            'room_id' => Room::factory()->create(['status' => 1])->id,
            'tenant_id' => $tenant->id,
            'landlord_id' => $landlord->id,
            'start_date' => Carbon::now()->subMonth(),
            'end_date' => Carbon::now()->addMonth(), // Hợp đồng còn hiệu lực
            'status' => 'active',
            'tenant_signed' => true,
            'landlord_signed' => true,
        ]);

        // Chạy lệnh cập nhật hợp đồng hết hạn
        $this->artisan('app:update-expired-contracts')
            ->expectsOutput('Found 1 expired contracts')
            ->expectsOutput('Contract #' . $expiredContract->contract_number . ' marked as expired')
            ->assertSuccessful();

        // Kiểm tra hợp đồng đã được cập nhật
        $this->assertEquals('expired', $expiredContract->fresh()->status);

        // Kiểm tra hợp đồng còn hiệu lực không bị ảnh hưởng
        $this->assertEquals('active', $activeContract->fresh()->status);

        // Kiểm tra trạng thái phòng đã được cập nhật
        $this->assertEquals(0, $room->fresh()->status, 'Room status should be updated to available (0)');
    }
}
