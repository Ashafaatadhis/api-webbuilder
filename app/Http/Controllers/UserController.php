<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role:administrator');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("role", "store_owner")->paginate(10);
        $user = new UserCollection($user);
        return $this->sendResponse($user, "Successfully get All Data");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where("role", "store_owner")->find($id);
        if (!$user) {
            return $this->sendError("Not Found", "User Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new UserCollection(collect($user));
        return $this->sendResponse(message: "Successfully get Data", data: $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::where("role", "store_owner")->find($id);

        if (!$user) {
            return $this->sendError("Not Found", "User Not found", Response::HTTP_NOT_FOUND);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $result = $this->uploadSingle($request, "user", 'image');
            File::delete($user->image);
            $data['image'] = $result->getPathname();
        } else {
            $data['image'] = $user->image;
        }


        $user = $user->update($data);
        if (!$user) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }


        $user = User::where('id', $id)->first();
        $data = new UserCollection(collect($user));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::where("role", "store_owner")->find($id);

        if (!$user) {
            return $this->sendError("Not Found", "User Not found", Response::HTTP_NOT_FOUND);
        }


        if (!$user->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }
        File::delete($user->image);
        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
