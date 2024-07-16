<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;



class Controller extends BaseController
{
    protected function sendError($message, $errorMessages = [], $status = Response::HTTP_BAD_REQUEST, $errors = [])
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    protected function sendResponse(ResourceCollection|string $data = 'empty', $message = '', $extra = [])
    {
        $response = [
            'status' => Response::HTTP_OK,
            'message' => $message,
        ];


        if ($data === 'empty') {
            return response()->json(array_merge($response, $extra), Response::HTTP_OK);
        }

        $merge = array_merge($response, $extra);

        return $data->additional($merge);

        // if ($data !== 'empty') {
        //     $response['data'] = new StoreResource($data);
        // }

        // return response()->json($response, Response::HTTP_OK);
    }

    protected function uploadMulti(Request $request, string $folder, string $namefile)
    {
        $files = $request->file($namefile);
        $listUpload = [];

        foreach ($files as $f) {
            $result = $f->move("upload\\" . $folder, Str::uuid()->toString()  . "." . $f->getClientOriginalExtension());
            $listUpload[] = $result;
        }
        return $listUpload;
    }
    protected function uploadSingle(Request $request, string $folder, string $namefile)
    {
        $file = $request->file($namefile);

        $result = $file->move("upload\\" . $folder, Str::uuid()->toString()  . "." . $file->getClientOriginalExtension());

        return $result;
    }
}
