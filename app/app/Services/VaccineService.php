<?php

namespace App\Services;

use App\Enums\ScheduleStatus;
use App\Mail\VaccineNotification;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class VaccineService
{

    public function __construct(protected VaccineCenterService $vaccineCenterService)
    {
        //
    }

    /**
     * Registers a user for vaccine and sends a notification email.
     *
     * @param  array  $attributes
     * @return \App\Models\VaccineRegistration
     */
    public function vaccineRegister(array $attributes)
    {
        try {
            $userData = array_merge(Arr::only($attributes, ['name', 'email', 'nid']), [
                'password' => 'secret'
            ]);

            DB::beginTransaction();

            $user = User::create($userData);

            $registration = $this->vaccineCenterService->scheduleVaccineDate($user->id, Arr::get($attributes, 'vaccine_center_id'));

            DB::commit();

            // Immediately notify the user about their scheduled vaccination date
            Mail::to($user->email)->send(new VaccineNotification($registration));
            return $registration;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function searchSchedule($nid)
    {
        $user = User::with('vaccineRegistration.vaccineCenter:id,name,address')->where('nid', $nid)->first();

        if (!$user) {
            return ['status' => ScheduleStatus::NOT_REGISTERED->value];
        }

        $registration = $user->vaccineRegistration;
        if (!$registration) {
            return ['status' => ScheduleStatus::NOT_SCHEDULED->value];
        }

        if ($registration->is_vaccinated) {
            return ['status' => ScheduleStatus::VACCINATED->value];
        }

        $scheduledDate = Carbon::parse($registration->scheduled_date);

        if ($scheduledDate->isPast()) {
            return ['status' => ScheduleStatus::SCHEDULED_DATE_OVER->value];
        }

        return [
            'status' => ScheduleStatus::SCHEDULED->value,
            'scheduled_date' => $scheduledDate->format('l, F jS, Y'),
            'vaccine_center' => $registration?->vaccineCenter->only(['name', 'address'])
        ];
    }
}
