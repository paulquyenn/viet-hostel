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

test('user with active contract cannot create new booking', function () {
    // Create user
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    // Create active contract
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
        'terms_and_conditions' => 'Test contract terms',
    ]);

    // Attempt to create a booking
    $this->actingAs($user)
        ->post(route('tenant.bookings.store', ['room' => $this->room->id]), [
            'room_id' => $this->room->id,
            'desired_move_date' => now()->addDays(1)->format('Y-m-d'),
            'duration' => 6,
            'note' => 'Test booking message'
        ])        ->assertRedirect()
        ->assertSessionHas('error');
});

test('user with pending contract cannot create new booking', function () {
    // Create user
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    // Create pending contract
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
        'terms_and_conditions' => 'Test contract terms',
    ]);

    // Attempt to create a booking
    $this->actingAs($user)
        ->post(route('tenant.bookings.store', ['room' => $this->room->id]), [
            'room_id' => $this->room->id,
            'desired_move_date' => now()->addDays(1)->format('Y-m-d'),
            'duration' => 6,
            'note' => 'Test booking message'
        ])        ->assertRedirect()
        ->assertSessionHas('error');
});

test('user with pending booking cannot create new booking', function () {
    // Create user
    $user = User::factory()->create();

    // Create pending booking
    Booking::create([
        'room_id' => $this->room->id,
        'user_id' => $user->id,
        'status' => 'pending',
        'desired_move_date' => now()->addDays(1),
        'duration' => 6,
        'note' => 'Existing booking',
    ]);

    // Attempt to create another booking
    $this->actingAs($user)
        ->post(route('tenant.bookings.store', ['room' => $this->room->id]), [
            'room_id' => $this->room->id,
            'desired_move_date' => now()->addDays(1)->format('Y-m-d'),
            'duration' => 6,
            'note' => 'Test booking message'
        ])        ->assertRedirect()
        ->assertSessionHas('error');
});

test('user without active contract or pending booking can create booking', function () {
    // Create user
    $user = User::factory()->create();

    // Attempt to create a booking (should succeed)
    $this->actingAs($user)
        ->post(route('tenant.bookings.store', ['room' => $this->room->id]), [
            'room_id' => $this->room->id,
            'desired_move_date' => now()->addDays(1)->format('Y-m-d'),
            'duration' => 6,
            'note' => 'Test booking message'
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    // Verify booking was created
    $this->assertDatabaseHas('bookings', [
        'user_id' => $user->id,
        'room_id' => $this->room->id,
        'status' => 'pending'
    ]);
});

test('user can access booking create form without restrictions', function () {
    // Create user
    $user = User::factory()->create();

    // Access booking create form
    $this->actingAs($user)
        ->get(route('tenant.bookings.create', ['room' => $this->room->id]))
        ->assertStatus(200);
});

test('user with rejected contract can create new booking', function () {
    // Create user
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    // Create rejected contract
    Contract::create([
        'contract_number' => 'CT004',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'terminated',
        'start_date' => now(),
        'end_date' => now()->addMonths(6),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test contract terms',
    ]);

    // Attempt to create a booking (should succeed)
    $this->actingAs($user)
        ->post(route('tenant.bookings.store', ['room' => $this->room->id]), [
            'room_id' => $this->room->id,
            'desired_move_date' => now()->addDays(1)->format('Y-m-d'),
            'duration' => 6,
            'note' => 'Test booking message'
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
});

test('user with expired contract can create new booking', function () {
    // Create user
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    // Create expired contract
    Contract::create([
        'contract_number' => 'CT005',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'expired',
        'start_date' => now()->subMonths(6),
        'end_date' => now()->subDays(1),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test contract terms',
    ]);

    // Attempt to create a booking (should succeed)
    $this->actingAs($user)
        ->post(route('tenant.bookings.store', ['room' => $this->room->id]), [
            'room_id' => $this->room->id,
            'desired_move_date' => now()->addDays(1)->format('Y-m-d'),
            'duration' => 6,
            'note' => 'Test booking message'
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
});

test('hasActiveContract method returns true for active and pending contracts', function () {
    $user = User::factory()->create();
    $landlord = User::factory()->create();

    // Test active contract
    Contract::create([
        'contract_number' => 'CT006',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'active',
        'start_date' => now(),
        'end_date' => now()->addMonths(6),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test contract terms',
    ]);

    expect($user->hasActiveContract())->toBeTrue();

    // Clean up and test pending
    Contract::where('tenant_id', $user->id)->delete();
    Contract::create([
        'contract_number' => 'CT007',
        'room_id' => $this->room->id,
        'tenant_id' => $user->id,
        'landlord_id' => $landlord->id,
        'status' => 'pending',
        'start_date' => now(),
        'end_date' => now()->addMonths(6),
        'monthly_rent' => 1000000,
        'deposit_amount' => 2000000,
        'terms_and_conditions' => 'Test contract terms',
    ]);

    expect($user->hasActiveContract())->toBeTrue();
});

test('hasPendingBooking method returns true for pending bookings', function () {
    $user = User::factory()->create();

    // Initially no pending booking
    expect($user->hasPendingBooking())->toBeFalse();

    // Create pending booking
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
