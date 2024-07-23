<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $store = User::with(["stores"])->find($user->id);

        $data = new UserCollection(collect($store));
        return $this->sendResponse(message: "Successfully get All Data", data: $data);
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
        //
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
    public function update(ProfileRequest $request)
    {

        $user = Auth::user();

        $user = User::find($user->id);


        // $token = Auth::attempt(["email" => $user->email, "password" => $request->password]);
        // if (!$token) {
        //     return $this->sendError('Unauthorized', 'Wrong credentials!', Response::HTTP_UNAUTHORIZED);
        // }
        $data = $request->only(["image", "username"]);

        if ($request->hasFile('image')) {

            $result = $this->uploadSingle($request, "user", 'image');
            File::delete($user->image);
            $data['image'] = $result->getPathname();
        } else {
            $data['image'] = $user->image;
        }

        $update = $user->update($data);
        if (!$update) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('id', $user->id)->first();
        $data = new UserCollection(collect($user));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    public function updatePassword(ProfileRequest $request)
    {

        $user = Auth::user();

        $user = User::find($user->id);


        $token = Auth::attempt(["email" => $user->email, "password" => $request->password]);
        if (!$token) {
            return $this->sendError('Unauthorized', 'Wrong credentials!', Response::HTTP_UNAUTHORIZED);
        }

        $update = $user->update(["password" => Hash::make($request->new_password)]);
        if (!$update) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('id', $user->id)->first();
        $data = new UserCollection(collect($user));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfileRequest $request)
    {
        $user = Auth::user();

        $user = User::find($user->id);


        $token = Auth::attempt(["email" => $user->email, "password" => $request->password]);
        if (!$token) {
            return $this->sendError('Unauthorized', 'Wrong credentials!', Response::HTTP_UNAUTHORIZED);
        }

        if (!$user->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }
        File::delete($user->image);
        return $this->sendResponse(message: "Successfully delete this account!");
    }
}
