<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomBookedDate;
use App\Services\RoomAvailabilityService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;

class RoomAvailabilityServiceTest extends TestCase
{
    protected $roomAvailabilityService;

    public function setUp(): void
    {
        parent::setUp();

        // Instantiate the service
        $this->roomAvailabilityService = new RoomAvailabilityService();
    }

    public function tearDown(): void
    {
        // Close mockery after each test
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_returns_available_rooms_for_given_date_range_and_persons()
    {
        // Set up mock for RoomBookedDate model
        $roomBookedDateMock = Mockery::mock('alias:' . RoomBookedDate::class);
        $roomBookedDateMock->shouldReceive('whereIn')
            ->once()
            ->andReturnSelf();
        $roomBookedDateMock->shouldReceive('distinct')
            ->once()
            ->andReturnSelf();
        $roomBookedDateMock->shouldReceive('pluck')
            ->once()
            ->andReturn(collect([1, 2])); // Mock booking IDs

        // Set up mock for Room model
        $roomMock = Mockery::mock('alias:' . Room::class);
        $roomMock->shouldReceive('with')
            ->once()
            ->andReturnSelf();
        $roomMock->shouldReceive('withCount')
            ->once()
            ->andReturnSelf();
        $roomMock->shouldReceive('where')
            ->once()
            ->andReturnSelf();
        $roomMock->shouldReceive('get')
            ->once()
            ->andReturn(collect([
                (object) [
                    'id' => 1,
                    'roomType' => (object)['id' => 1, 'name' => 'Deluxe Suite'],
                    'room_numbers_count' => 5,
                    'total_adults' => 4
                ],
                (object) [
                    'id' => 2,
                    'roomType' => (object)['id' => 2, 'name' => 'Standard Room'],
                    'room_numbers_count' => 3,
                    'total_adults' => 2
                ]
            ]));

        // Set up mock for Booking model
        $bookingMock = Mockery::mock('alias:' . Booking::class);
        $bookingMock->shouldReceive('whereIn')
            ->twice()
            ->andReturnSelf();
        $bookingMock->shouldReceive('where')
            ->twice()
            ->andReturnSelf();
        $bookingMock->shouldReceive('withCount')
            ->twice()
            ->andReturnSelf();
        $bookingMock->shouldReceive('get')
            ->twice()
            ->andReturn(collect([
                (object) ['booking_rooms_count' => 2], // 2 rooms booked
            ]));

        // Call the service method
        $availableRooms = $this->roomAvailabilityService->checkAvailability('2024-09-15', '2024-09-20', 2);

        // Assert that the response contains the expected rooms
        $this->assertNotFalse($availableRooms);
        $this->assertCount(2, $availableRooms);
        $this->assertEquals(1, $availableRooms[0]['room_id']);
        $this->assertEquals(2, $availableRooms[1]['room_id']);
        $this->assertEquals(3, $availableRooms[0]['available_rooms']); // 5 total - 2 booked = 3 available
        $this->assertEquals(1, $availableRooms[1]['available_rooms']); // 3 total - 2 booked = 1 available
    }

    /** @test */
    public function it_returns_false_if_no_rooms_are_available()
    {
        // Mock RoomBookedDate to return no bookings
        $roomBookedDateMock = Mockery::mock('alias:' . RoomBookedDate::class);
        $roomBookedDateMock->shouldReceive('whereIn')
            ->once()
            ->andReturnSelf();
        $roomBookedDateMock->shouldReceive('distinct')
            ->once()
            ->andReturnSelf();
        $roomBookedDateMock->shouldReceive('pluck')
            ->once()
            ->andReturn(collect([])); // No booking IDs

        // Mock Room model to return no available rooms
        $roomMock = Mockery::mock('alias:' . Room::class);
        $roomMock->shouldReceive('with')
            ->once()
            ->andReturnSelf();
        $roomMock->shouldReceive('withCount')
            ->once()
            ->andReturnSelf();
        $roomMock->shouldReceive('where')
            ->once()
            ->andReturnSelf();
        $roomMock->shouldReceive('get')
            ->once()
            ->andReturn(collect([])); // No rooms

        // Call the service method
        $availableRooms = $this->roomAvailabilityService->checkAvailability('2024-09-15', '2024-09-20', 2);

        // Assert that no rooms are available
        $this->assertFalse($availableRooms);
    }

    /** @test */
    public function it_handles_exceptions_and_returns_false()
    {
        // Mock RoomBookedDate to throw an exception
        $roomBookedDateMock = Mockery::mock('alias:' . RoomBookedDate::class);
        $roomBookedDateMock->shouldReceive('whereIn')
            ->once()
            ->andThrow(new \Exception('Database error'));

        // Mock logging
        Log::shouldReceive('error')
            ->once()
            ->with('Error checking availability: Database error');

        // Call the service method and assert that it returns false
        $availableRooms = $this->roomAvailabilityService->checkAvailability('2024-09-15', '2024-09-20', 2);

        $this->assertFalse($availableRooms);
    }
}