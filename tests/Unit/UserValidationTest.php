<?php

use App\Models\User;
use App\Models\Room;
use App\Models\Building;
use App\Models\Contract;
use App\Models\Booking;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create basic location data
    $province = Province::create(['name' => 'Test Province']);
    $district = District::create(['name' => 'Test District', 'province_id' => $province->id]);
    $ward = Ward::create(['name' => 'Test Ward', 'district_id' => $district->id]);

    // Create a user for the building owner
    $buildingOwner = User::factory()->create();

    // Create building and room
    $building = Building::create([
        'name' => 'Test Building',
        'address' => 'Test Address',
        'user_id' => $buildingOwner->id,
        'province_id' => $province->id,
        'district_id' => $district->id,
        'ward_id' => $ward->id,
    ]);

    $this->room = Room::create([
        'room_number' => 'A101',
        'building_id' => $building->id,
        'price' => 1000000,
        'deposit' => 2000000,
        'area' => 25,
        'max_person' => 2,
        'status' => 'available',
        'description' => 'Test room',
    ]);
});

test('hasActiveContract returns true for active contract', function () {
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    Contract::create([
        'contract_number' => 'CT001',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'active',
        'start_date' => now(),
        'end_date' => now()->addMonths(6),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test terms',
    ]);

    expect($user->hasActiveContract())->toBeTrue();
});

test('hasActiveContract returns true for pending contract', function () {
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    Contract::create([
        'contract_number' => 'CT002',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'pending',
        'start_date' => now(),
        'end_date' => now()->addMonths(6),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test terms',
    ]);

    expect($user->hasActiveContract())->toBeTrue();
});

test('hasActiveContract returns false for rejected contract', function () {
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    Contract::create([
        'contract_number' => 'CT003',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'terminated', // Using terminated instead of rejected
        'start_date' => now(),
        'end_date' => now()->addMonths(6),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test terms',
    ]);

    expect($user->hasActiveContract())->toBeFalse();
});

test('hasActiveContract returns false for expired contract', function () {
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    Contract::create([
        'contract_number' => 'CT004',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'expired',
        'start_date' => now()->subMonths(6),
        'end_date' => now()->subDays(1),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test terms',
    ]);

    expect($user->hasActiveContract())->toBeFalse();
});

test('hasPendingBooking returns true for pending booking', function () {
    $user = User::factory()->create();

    Booking::create([
        'room_id' => $this->room->id,
        'user_id' => $user->id,
        'status' => 'pending',
        'desired_move_date' => now()->addDays(1),
        'duration' => 6,
        'note' => 'Test booking',
    ]);

    expect($user->hasPendingBooking())->toBeTrue();
});

test('hasPendingBooking returns false for approved booking', function () {
    $user = User::factory()->create();

    Booking::create([
        'room_id' => $this->room->id,
        'user_id' => $user->id,
        'status' => 'approved',
        'desired_move_date' => now()->addDays(1),
        'duration' => 6,
        'note' => 'Test booking',
    ]);

    expect($user->hasPendingBooking())->toBeFalse();
});

test('hasPendingBooking returns false for rejected booking', function () {
    $user = User::factory()->create();

    Booking::create([
        'room_id' => $this->room->id,
        'user_id' => $user->id,
        'status' => 'rejected',
        'desired_move_date' => now()->addDays(1),
        'duration' => 6,
        'note' => 'Test booking',
    ]);

    expect($user->hasPendingBooking())->toBeFalse();
});

test('getActiveContract returns correct contract', function () {
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    $contract = Contract::create([
        'contract_number' => 'CT005',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'active',
        'start_date' => now(),
        'end_date' => now()->addMonths(6),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test terms',
    ]);

    $activeContract = $user->getActiveContract();
    expect($activeContract)->not->toBeNull();
    expect($activeContract->id)->toBe($contract->id);
    expect($activeContract->contract_number)->toBe('CT005');
});

test('getPendingBooking returns correct booking', function () {
    $user = User::factory()->create();

    $booking = Booking::create([
        'room_id' => $this->room->id,
        'user_id' => $user->id,
        'status' => 'pending',
        'desired_move_date' => now()->addDays(1),
        'duration' => 6,
        'note' => 'Test booking message',
    ]);

    $pendingBooking = $user->getPendingBooking();
    expect($pendingBooking)->not->toBeNull();
    expect($pendingBooking->id)->toBe($booking->id);
    expect($pendingBooking->note)->toBe('Test booking message');
});

test('user with no contracts or bookings has no active contract or pending booking', function () {
    $user = User::factory()->create();

    expect($user->hasActiveContract())->toBeFalse();
    expect($user->hasPendingBooking())->toBeFalse();
    expect($user->getActiveContract())->toBeNull();
    expect($user->getPendingBooking())->toBeNull();
});
