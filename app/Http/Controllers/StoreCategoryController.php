<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\TemplateCategoryCollection;

use App\Models\StoreCategory;

use Illuminate\Http\Response;




class StoreCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ["except" => ["index", "show"]]);
        $this->middleware('role:administrator', ["except" => ["index", "show"]]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(StoreCategoryRequest $request)
    {
        $limit = $request->query('limit', 10);
        $templateCategory = new StoreCategory();

        if ($request->has('sort')) {
            if ($request->query('sort') === 'ascending') {
                $templateCategory = $templateCategory->orderBy('name', 'asc');
            } else if ($request->query('sort') === 'descending') {
                $templateCategory = $templateCategory->orderBy('name', 'desc');
            }
        }


        if ($request->has('paginate')) {
            $page = $request->query('paginate');
            if ($page === "true") {
                $templateCategory = $templateCategory->paginate($limit);
            } else {
                $templateCategory = $templateCategory->get();
            }
        } else {
            $templateCategory = $templateCategory->get();
        }



        $templateCategory = new TemplateCategoryCollection(collect($templateCategory));
        return $this->sendResponse($templateCategory, "Successfully get All Data");
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
    public function store(StoreCategoryRequest $request)
    {



        $template = StoreCategory::create($request->all());


        $data = new TemplateCategoryCollection(collect($template));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $templateCategory = StoreCategory::find($id);
        if (!$templateCategory) {
            return $this->sendError("Not Found", "Store Category Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new TemplateCategoryCollection(collect($templateCategory));
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
    public function update(StoreCategoryRequest $request, string $id)
    {
        $templateCategory = StoreCategory::find($id);

        if (!$templateCategory) {
            return $this->sendError("Not Found", "Store Category Not found", Response::HTTP_NOT_FOUND);
        }




        $templateCategory = $templateCategory->update($request->all());
        if (!$templateCategory) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $templateCategory = StoreCategory::where('id', $id)->first();
        $data = new TemplateCategoryCollection(collect($templateCategory));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $templateCategory = StoreCategory::find($id);

        if (!$templateCategory) {
            return $this->sendError("Not Found", "Store Category Not found", Response::HTTP_NOT_FOUND);
        }



        if (!$templateCategory->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
