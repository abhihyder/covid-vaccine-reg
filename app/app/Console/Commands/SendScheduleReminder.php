<?php

namespace App\Console\Commands;

use App\Mail\VaccineNotification;
use Illuminate\Console\Command;
use App\Models\VaccineRegistration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendScheduleReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to users about their vaccine schedule for the next day';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get users who are scheduled for vaccination tomorrow
        $tomorrow = Carbon::now()->addDay()->toDateString();

        $registrations = VaccineRegistration::with(['user', 'vaccineCenter'])
            ->where('scheduled_date', $tomorrow)
            ->where('is_vaccinated', false)
            ->get();
        foreach ($registrations as $registration) {
            // Send reminder notification
            Mail::to($registration->user->email)
                ->send(new VaccineNotification($registration));
        }

        $this->info('Reminders sent to users scheduled for tomorrow.');
    }
}
