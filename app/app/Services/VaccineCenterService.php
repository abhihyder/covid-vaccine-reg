<?php

namespace App\Services;

use App\Models\VaccineRegistration;
use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class VaccineCenterService
{
    public function __construct()
    {
        //
    }

    /**
     * Returns a collection of VaccineCenter instances containing only 'id', 'name', and 'address' fields.
     *
     * @return Collection<VaccineCenter>
     */
    public function getVaccineCenters(): Collection
    {
        return VaccineCenter::get(['id', 'name', 'address']);
    }

    /**
     * Schedules a vaccine date for a user at a given vaccine center.
     *
     * @param int $userId The ID of the user to schedule the vaccine for.
     * @param int $vaccineCenterId The ID of the vaccine center to schedule the vaccine at.
     * @return VaccineRegistration The newly created VaccineRegistration instance.
     */
    public function scheduleVaccineDate(int $userId, int $vaccineCenterId): VaccineRegistration
    {
        $scheduleDate = $this->getNextAvailableDate($vaccineCenterId);

        return VaccineRegistration::create([
            'user_id' => $userId,
            'vaccine_center_id' => $vaccineCenterId,
            'scheduled_date' => $scheduleDate
        ]);
    }

    /**
     * Ensures that the given date falls on a weekday (Sunday to Thursday).
     *
     * @param Carbon $date The date to check.
     * @return Carbon The next available weekday.
     */
    public function getNextWeekday(Carbon $date): Carbon
    {
        // Check if the day is Friday (6) or Saturday (7), if so, move to Sunday
        while ($date->isFriday() || $date->isSaturday()) {
            $date->addDay();
        }

        return $date;
    }

    /**
     * Get the next available vaccine schedule date for a center based on its daily capacity.
     *
     * @param int $vaccineCenterId The ID of the vaccine center.
     * @return Carbon The next available schedule date.
     */
    protected function getNextAvailableDate(int $vaccineCenterId)
    {
        $vaccineCenter = VaccineCenter::findOrFail($vaccineCenterId);
        $dailyCapacity = $vaccineCenter->daily_capacity;

        $latestScheduled = VaccineRegistration::where('vaccine_center_id', $vaccineCenterId)
            ->latest('scheduled_date')
            ->first();

        // Set the initial schedule date
        $scheduleDate = $latestScheduled
            ? Carbon::parse($latestScheduled->scheduled_date)
            : Carbon::now()->addDay();

        // Check if the latest schedule date is full
        $latestScheduleCount = VaccineRegistration::where('vaccine_center_id', $vaccineCenterId)
            ->whereDate('scheduled_date', $scheduleDate)
            ->count();

        // If there is space for more people on the latest scheduled date, return that date
        if ($latestScheduleCount < $dailyCapacity) {
            return $this->getNextWeekday($scheduleDate);
        }

        // If the latest scheduled date is full, move to the next available date
        return $this->getNextWeekday($scheduleDate->addDay());
    }
}
