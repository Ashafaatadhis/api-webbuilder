<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificationRequest;
use App\Http\Resources\CertificationCollection;
use App\Models\Certification;
use App\Models\Store\Store;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;


class CertificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ["index", 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CertificationRequest $request)
    {
        $limit = $request->query('limit', 10);
        $certification =  new Certification();

        if ($request->has('storeId')) {
            $storeId = $request->query('storeId');

            $certification = $certification->where('store_id',  $storeId);
        }


        if ($request->has('paginate')) {
            $page = $request->query('paginate');
            if ($page  === "true") {
                $certification = $certification->paginate($limit);
            } else {
                $certification = $certification->get();
            }
        } else {
            $certification = $certification->get();
        }

        $certification = new CertificationCollection($certification);
        return $this->sendResponse($certification, "Successfully get All Data");
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
    public function store(CertificationRequest $request)
    {

        $store = Store::find($request->store_id);

        if (!$store) {

            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }
        Gate::authorize('create-store', $store);
        $result = $this->uploadSingle($request, "certification", 'image');

        $data = $request->all();

        $data['image'] = $result->getPathname();

        $certification = Certification::create($data);


        $data = new CertificationCollection(collect($certification));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $certification = Certification::find($id);
        if (!$certification) {
            return $this->sendError("Not Found", "Certification Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new CertificationCollection(collect($certification));
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
    public function update(CertificationRequest $request, string $id)
    {




        $certification = Certification::find($id);

        if (!$certification) {
            return $this->sendError("Not Found", "Certification Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($certification->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }



        Gate::authorize('update-store', $store);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $result = $this->uploadSingle($request, "certification", 'image');
            File::delete($certification->image);
            $data['image'] = $result->getPathname();
        } else {

            $data['image'] = $certification->image;
        }

        $certification = $certification->update($data);
        if (!$certification) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $certification = Certification::where('id', $id)->first();
        $data = new CertificationCollection(collect($certification));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $certification = Certification::find($id);

        if (!$certification) {
            return $this->sendError("Not Found", "Certification Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($certification->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }



        Gate::authorize('delete-store', $store);

        if (!$certification->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }
        File::delete($certification->image);
        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
