<?php

namespace App\Http\Controllers;

use App\Services\VaccineCenterService;
use Hyder\JsonResponse\Facades\JsonResponse;
use Illuminate\Http\Request;

class VaccineCenterController extends Controller
{
    public function __construct(protected VaccineCenterService $vaccineCenterService)
    {
        //
    }

    public function index()
    {
        $vaccineCenters = $this->vaccineCenterService->getVaccineCenters();
        return JsonResponse::withData(['vaccine_centers' => $vaccineCenters], 'Vaccine center list fetched successful');
    }
}
