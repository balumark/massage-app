<?php

namespace App\Http\Controllers\Api\Services;

use Exception;
use App\Facades\JsonResponser;
use App\Models\ServiceAppointment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\SuccessfullyAppointmentJob;
use App\Http\Requests\Service\RenewServiceAppointmentRequest;
use App\Persistence\Repositories\Interfaces\ServiceAppointmentRepository;


class RenewServiceAppointmentController extends Controller
{
    private $serviceAppointmentRepository;

    public function __construct(
        ServiceAppointmentRepository $serviceAppointmentRepository
    ) {
        $this->serviceAppointmentRepository = $serviceAppointmentRepository;
    }

    public function handle(RenewServiceAppointmentRequest $request)
    {
        try {

            $appointment = $this->serviceAppointmentRepository->findByAttributes([
                'service_id' => $request->service_id,
                'user_id' => auth()->user()->id,
                'time' => $request->from
            ]);

            if (!$appointment) {
                return JsonResponser::responseWithHttpCode('No appointment found!', null, 404);
            }

            $already_taken_appointment = $this->serviceAppointmentRepository->findByAttributes([
                'service_id' => $request->service_id,
                'time' => $request->to
            ]);

            if ($already_taken_appointment) {
                return JsonResponser::responseWithHttpCode('Appointment already taken!', null, 404);
            }


            DB::beginTransaction();
            $this->serviceAppointmentRepository->deleteById($appointment->id);
            $user = auth()->user();
            $appointment = new ServiceAppointment();
            $appointment->service_id = $request->service_id;
            $appointment->user_id = $user->id;
            $appointment->time = $request->to;
            $this->serviceAppointmentRepository->save($appointment);
            DB::commit();

            dispatch(new SuccessfullyAppointmentJob([
                'name' => $user->name,
                'email' => $user->email,
                'appointment' => $request->to,
            ]));

            return JsonResponser::responseWithHttpCode('Succcess', null, 204);
        } catch (Exception $exception) {
            return JsonResponser::fail('Failed to renew the appointment', null, $exception);
        }
    }
}
