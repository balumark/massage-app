<?php

namespace App\Http\Controllers\Api\Services;

use Exception;
use App\Facades\JsonResponser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\DeleteServiceAppointmentRequest;
use App\Persistence\Repositories\Interfaces\ServiceAppointmentRepository;


class DeleteServiceAppointmentController extends Controller
{
    private $serviceAppointmentRepository;

    public function __construct(
        ServiceAppointmentRepository $serviceAppointmentRepository
    ) {
        $this->serviceAppointmentRepository = $serviceAppointmentRepository;
    }

    public function handle(DeleteServiceAppointmentRequest $request)
    {
        try {

            $appointment = $this->serviceAppointmentRepository->findByAttributes([
                'service_id' => $request->service_id,
                'user_id' => auth()->user()->id,
                'time' => $request->time
            ]);

            if (!$appointment) {
                return JsonResponser::responseWithHttpCode('No appointment found!', null, 404);
            }
            DB::beginTransaction();
            $this->serviceAppointmentRepository->deleteById($appointment->id);
            DB::commit();

            return JsonResponser::responseWithHttpCode('Succcess', null, 204);
        } catch (Exception $exception) {
            return JsonResponser::fail('Failed to delete the appointment', null, $exception);
        }
    }
}
