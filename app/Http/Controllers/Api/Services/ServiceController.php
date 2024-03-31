<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Persistence\Repositories\Interfaces\ServiceRepository;
use App\ViewModels\Transformers\ServiceIndexTransformer;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Facades\JsonResponser;
use Exception;

class ServiceController extends Controller
{
    /**
     * @var Pipeline
     */
    private Pipeline $pipeline;

    /**ű
     * 
     */
    private $serviceRepository;

    private ServiceIndexTransformer $serviceIndexTransformer;

    public function __construct(Pipeline $pipeline, ServiceRepository $serviceRepository, ServiceIndexTransformer $serviceIndexTransformer)
    {
        $this->pipeline = $pipeline;
        $this->serviceRepository = $serviceRepository;
        $this->serviceIndexTransformer = $serviceIndexTransformer;
    }

    public function handle(Request $request)
    {
        try {
            $result = $this->pipeline->send(
                $this->serviceRepository->findForFilter()
            )
                ->thenReturn()
                ->get()
                ->map(function (Service $service) {
                    return  $this->serviceIndexTransformer->transform($service);
                });
            return JsonResponser::success('Succcess', $result);
        } catch (Exception $exception) {
            return JsonResponser::fail('Failed to fetch the services', null, $exception);
        }
    }
}
