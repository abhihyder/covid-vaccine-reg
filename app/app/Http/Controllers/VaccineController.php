<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\VaccineCenter;
use App\Models\VaccineRegistration;
use App\Services\VaccineService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hyder\JsonResponse\Facades\JsonResponse;

class VaccineController extends Controller
{

    public function __construct(protected VaccineService $vaccineService)
    {
        //
    }

    /**
     * Handles vaccine registration process
     *
     * @param RegistrationRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request)
    {
        $registration = $this->vaccineService->vaccineRegister($request->validated());
        return JsonResponse::created('Registration successful', $registration);
    }

    public function searchSchedule($nid)
    {
        $schedule = $this->vaccineService->searchSchedule($nid);
        return JsonResponse::withData(['schedule' => $schedule], 'Schedule search result');
    }
}
