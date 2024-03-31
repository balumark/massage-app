<?php

namespace App\Http\Controllers\Api\Services;

use Exception;
use App\Facades\JsonResponser;
use App\Models\ServiceAppointment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\SuccessfullyAppointmentJob;
use App\Http\Requests\Service\CreateServiceAppointmentRequest;
use App\Persistence\Repositories\Interfaces\ServiceRepository;
use App\Persistence\Repositories\Interfaces\ServiceAppointmentRepository;


class CreateServiceAppointmentController extends Controller
{

    private $serviceRepository;
    private $serviceAppointmentRepository;

    public function __construct(
        ServiceRepository $serviceRepository,
        ServiceAppointmentRepository $serviceAppointmentRepository
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->serviceAppointmentRepository = $serviceAppointmentRepository;
    }

    public function handle(CreateServiceAppointmentRequest $request)
    {
        try {

            $service = $this->serviceRepository->findById($request->service_id);

            $appointments = $service->appointments()->get()->map(function (ServiceAppointment $appointment) {
                return $appointment->time;
            })->toArray();

            if (in_array($request->time, $appointments)) {
                return JsonResponser::responseWithHttpCode('The period is not available.', null, 422);
            }
            DB::beginTransaction();
            $user = auth()->user();
            $appointment = new ServiceAppointment();
            $appointment->service_id = $request->service_id;
            $appointment->user_id = $user->id;
            $appointment->time = $request->time;
            $this->serviceAppointmentRepository->save($appointment);
            DB::commit();

            dispatch(new SuccessfullyAppointmentJob([
                'name' => $user->name,
                'email' => $user->email,
                'appointment' => $request->time,
            ]));

            return JsonResponser::responseWithHttpCode('Succcess', null, 201);
        } catch (Exception $exception) {
            return JsonResponser::fail('Failed to create the appointment', null, $exception);
        }
    }
}
