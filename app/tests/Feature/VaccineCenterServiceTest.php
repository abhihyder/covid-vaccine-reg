<?php

namespace Tests\Feature;

use App\Models\VaccineRegistration;
use App\Services\VaccineCenterService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use ReflectionClass;
use Tests\TestCase;

class VaccineCenterServiceTest extends TestCase
{
    protected $vaccineCenterService;

    /**
     * Sets up the test environment before each test.
     *
     * This method initializes the VaccineCenterService instance
     * that will be used in the tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->vaccineCenterService = $this->app->make(VaccineCenterService::class);
    }

    /**
     * Test that VaccineCenterService::getVaccineCenters returns a collection
     * of VaccineCenter instances.
     */
    public function testGetVaccineCenters()
    {
        $vaccineCenters = $this->vaccineCenterService->getVaccineCenters();
        $this->assertInstanceOf(Collection::class, $vaccineCenters);
    }

    /**
     * Test that VaccineCenterService::getNextWeekday correctly returns the next weekday.
     *
     * This test verifies that given a date that falls on a Friday, the method
     * returns the following Sunday, ensuring the returned date is a weekday.
     */
    public function testGetNextWeekday()
    {
        $initialDate = Carbon::parse('2024-10-11'); // A Friday
        $expectedDate = Carbon::parse('2024-10-13'); // Next Sunday

        $nextWeekday = $this->vaccineCenterService->getNextWeekday($initialDate);

        $this->assertEquals($expectedDate, $nextWeekday);
    }


    /**
     * Test that VaccineCenterService::scheduleVaccineDate successfully schedules a vaccine date.
     *
     * This test verifies that given a user ID and a vaccine center ID,
     * the method creates a VaccineRegistration instance.
     */
    public function testScheduleVaccineDate()
    {
        $userId = 1;
        $vaccineCenterId = 1;

        $registration = $this->vaccineCenterService->scheduleVaccineDate($userId, $vaccineCenterId);

        $this->assertInstanceOf(VaccineRegistration::class, $registration);
    }

    /**
     * Test that VaccineCenterService::getNextAvailableDate returns a Carbon instance
     * representing the next available vaccine schedule date for a given vaccine center.
     *
     * This test verifies that the method successfully calculates the next available
     * schedule date based on the daily capacity of the vaccine center.
     */
    public function testGetNextAvailableDate()
    {
        $reflection = new ReflectionClass(VaccineCenterService::class);
        $method = $reflection->getMethod('getNextAvailableDate');
        $method->setAccessible(true);

        $vaccineCenterId = 1;
        // Invoke the method on the instance with the necessary parameters
        $scheduledDate = $method->invoke($this->vaccineCenterService, $vaccineCenterId);

        $this->assertInstanceOf(Carbon::class, $scheduledDate);
    }
}
