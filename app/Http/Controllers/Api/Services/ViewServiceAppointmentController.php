<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use App\Persistence\Repositories\Interfaces\ServiceRepository;
use App\Facades\JsonResponser;
use App\Helper\ServiceTimeTableScheduller;
use App\Http\Requests\Service\ViewServiceAppointmentRequest;
use App\Models\ServiceAppointment;
use Exception;


class ViewServiceAppointmentController extends Controller
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function handle(ViewServiceAppointmentRequest $request)
    {
        try {

            $service = $this->serviceRepository->findById($request->service_id);

            $appointments = $service->appointments()->get()->map(function (ServiceAppointment $appointment) {
                return $appointment->time;
            })->toArray();

            $result = ServiceTimeTableScheduller::createScheduleForAuthUser($appointments);

            return JsonResponser::success('Succcess', array_values($result));
        } catch (Exception $exception) {
            return JsonResponser::fail('Failed to fetch the services', null, $exception);
        }
    }
}
