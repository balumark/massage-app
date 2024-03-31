<?php

namespace App\Helper;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ApiJsonResponser
{
     private static function logError($message, Exception $exception = null)
     {
          $context = self::buildExceptionContextToLog($exception);
          Log::channel("stack")->error($exception ? $exception->getMessage() : $message, $context);
     }
     private static function buildExceptionContextToLog(Exception $exception): array
     {
          return $exception === null ? [] : [
               $exception->getCode(),
               $exception->getMessage(),
               $exception->getLine(),
               $exception->getFile()
          ];
     }
     private static function buildResponseDataToRepond($message = null, $data = null): array
     {
          return [
               'message' => $message,
               'data' => $data
          ];
     }
     public static function success($message = null, $data = null): JsonResponse
     {
          return self::respond(Response::HTTP_OK, self::buildResponseDataToRepond($message, $data));
     }

     public static function fail($message = null, $data = null, Exception $exception = null): JsonResponse
     {
          self::logError($message, $exception);
          return self::respond(Response::HTTP_INTERNAL_SERVER_ERROR, self::buildResponseDataToRepond($message, $data));
     }

     public static function responseWithHttpCode($message = null, $data = null, $http_code = Response::HTTP_I_AM_A_TEAPOT): JsonResponse
     {
          return self::respond($http_code, self::buildResponseDataToRepond($message, $data));
     }

     protected static function respond($status_code, $data, $headers = []): JsonResponse
     {
          return response()
               ->json($data, $status_code, $headers, JSON_UNESCAPED_SLASHES);
     }

     public static function requestValidatorResponse($validator): JsonResponse
     {
          throw new HttpResponseException(
               self::respond(Response::HTTP_UNPROCESSABLE_ENTITY, self::buildResponseDataToRepond('Validation failed!', $validator->errors()))
          );
     }
}
