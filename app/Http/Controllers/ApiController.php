<?php

namespace App\Http\Controllers;

use App\Helpers\Filterable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function created($data): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => ('Create successfully'),
            'success' => true
        ], Response::HTTP_CREATED);
    }

    protected function updated($data = null, $msg = 'Update successfully'): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => ($msg),
            'success' => true
        ]);
    }

    protected function deleted($data = null, $msg = 'Delete successfully'): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => ($msg),
            'success' => true
        ], Response::HTTP_OK);
    }

    protected function restored($data = null, $msg = 'Restore successfully'): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => ($msg),
            'success' => true
        ], Response::HTTP_OK);
    }

    protected function forceDeleted($data = null, $msg = 'Force delete successfully'): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => ($msg),
            'success' => true
        ], Response::HTTP_OK);
    }

    protected function okWithData($data = null, $msg = 'Request successfully'): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => ($msg),
            'success' => true
        ], Response::HTTP_OK);
    }

    // public function okWithDataAndHeader($header, $data, $msg = 'Request successfully'): JsonResponse
    // {

    //     return response()->json([
    //         'data' => $data,
    //         'header' => (new Filterable)->guessIdData($header),
    //         'message' => ($msg),
    //         'success' => true
    //     ], Response::HTTP_OK);
    // }

    protected function okWithMsg($msg): JsonResponse
    {
        return response()->json([
            'message' => ($msg),
            'success' => true
        ], Response::HTTP_OK);
    }

    protected function msgWithCode($msg, $code, $success = false): JsonResponse
    {
        return response()->json([
            'message' => ($msg),
            'success' => $success
        ], $code);
    }

    protected function errors($errors): JsonResponse
    {
        return response()->json([
            'message' => ('The given data was invalid.'),
            'errors' => $errors,
            'success' => false
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function noContent(): JsonResponse
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    protected function file($fullPath, $name = null)
    {
        return response()->download($fullPath, $name ?? basename($fullPath));
    }
}
