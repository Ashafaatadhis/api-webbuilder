<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\TestimonialRequest;
use App\Http\Resources\TestimonialCollection;
use App\Models\Store\Store;
use App\Models\Testimonial;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;


class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ["index", 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonial = Testimonial::paginate(10);
        $testimonial = new TestimonialCollection($testimonial);
        return $this->sendResponse($testimonial, "Successfully get All Data");
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
    public function store(TestimonialRequest $request)
    {

        $store = Store::find($request->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('create-store', $store);
        $result = $this->uploadSingle($request, "testimonial", 'image');

        $data = $request->all();

        $data['image'] = $result->getPathname();

        $testimonial = Testimonial::create($data);


        $data = new TestimonialCollection(collect($testimonial));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return $this->sendError("Not Found", "Testimonial Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new TestimonialCollection(collect($testimonial));
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
    public function update(TestimonialRequest $request, string $id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return $this->sendError("Not Found", "Testimonial Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($testimonial->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);


        $data = $request->all();

        if ($request->hasFile('image')) {
            $result = $this->uploadSingle($request, "testimonial", 'image');
            File::delete($testimonial->image);
            $data['image'] = $result->getPathname();
        } else {
            $data['image'] = $testimonial->image;
        }

        $testimonial = $testimonial->update($data);
        if (!$testimonial) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $testimonial = Testimonial::where('id', $id)->first();
        $data = new TestimonialCollection(collect($testimonial));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return $this->sendError("Not Found", "Testimonial Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($testimonial->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('delete-store', $store);

        if (!$testimonial->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }
        File::delete($testimonial->image);

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
