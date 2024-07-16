<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\TemplateRequest;
use App\Http\Resources\Template\TemplateCollection;
use App\Models\Store\Store;
use App\Models\Template\Template;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Gate;


class TemplateController extends Controller
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
        $template = Template::paginate(10);
        $template = new TemplateCollection($template);
        return $this->sendResponse($template, "Successfully get All Data");
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
    public function store(TemplateRequest $request)
    {

        $store = Store::find($request->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('create-store', $store);
        //  unique store_id

        $template = Template::create($request->all());

        // dd(is_array($request->file('file')) ? count($request->file('file')) : $request->file('file'));
        // $listUpload = $this->uploadMulti($request, $product);

        // $product->image = $listUpload;

        $data = new TemplateCollection(collect($template));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $template = Template::find($id);
        if (!$template) {
            return $this->sendError("Not Found", "Template Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new TemplateCollection(collect($template));
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
    public function update(TemplateRequest $request, string $id)
    {




        $template = Template::find($id);

        if (!$template) {
            return $this->sendError("Not Found", "Template Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($template->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);



        $template = $template->update($request->all());
        if (!$template) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $template = Template::where('id', $id)->first();
        $data = new TemplateCollection(collect($template));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $template = Template::find($id);
        if (!$template) {
            return $this->sendError("Not Found", "Template Not found", Response::HTTP_NOT_FOUND);
        }
        $store = Store::find($template->store_id);
        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }


        Gate::authorize('delete-store', $store);

        if (!$template->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
