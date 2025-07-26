<?php
namespace App\Http\Controllers\API\Base;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class BaseApiController extends BaseController
{
    protected function success($data = null, $message = 'Success', $code = 200)
    {

        if ($data instanceof \Illuminate\Http\Resources\Json\JsonResource) {
        return $data->additional([
            'success' => true,
            'message' => $message,
        ])->response()->setStatusCode($code);
    }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /*protected function error($message = 'Something went wrong', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }*/

    protected function error(string $message = 'Something went wrong',int $code = 400, ?\Throwable $e = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        // In development, include exception message
        if (app()->environment('local') && $e) {
            $response['error'] = $e->getMessage();
        }

        return response()->json($response, $code);
    }
}
