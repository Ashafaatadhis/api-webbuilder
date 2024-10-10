<?php

namespace App\Http\Controllers\Template\Section;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\Section\StrengthSectionRequest;
use App\Http\Resources\Template\SectionCollection;
use App\Models\Store\Store;
use App\Models\Template\Section\StrengthSection;
use App\Models\Template\Template;
use App\Models\Template\TemplateLink;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class StrengthSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ["index", 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(StrengthSectionRequest $request)
    {
        $limit = $request->query('limit', 10);
        $section = StrengthSection::paginate($limit);
        $section = new SectionCollection($section);
        return $this->sendResponse($section, "Successfully get All Data");
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
    public function store(StrengthSectionRequest $request)
    {



        $template = TemplateLink::find($request->templateLink_id);

        if (!$template) {
            return $this->sendError("Not Found", "Template Link Not found", Response::HTTP_NOT_FOUND);
        }



        $store = Store::find($template->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('create-store', $store);
        $data = $request->all();
        if ($request->hasFile('image')) {

            //  unique store_id
            $result = $this->uploadSingle($request, "section", 'image');

            $data = $request->all();

            $data['image'] = $result->getPathname();
        }

        $section = StrengthSection::create($data);

        // dd(is_array($request->file('file')) ? count($request->file('file')) : $request->file('file'));
        // $listUpload = $this->uploadMulti($request, $product);

        // $product->image = $listUpload;

        $data = new SectionCollection(collect($section));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $section = StrengthSection::find($id);

        if (!$section) {
            return $this->sendError("Not Found", "Strength Section Not found", Response::HTTP_NOT_FOUND);
        }

        $data = new SectionCollection(collect($section));
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
    public function update(StrengthSectionRequest $request, string $id)
    {


        $section = StrengthSection::find($id);

        if (!$section) {
            return $this->sendError("Not Found", "Strength Section Not found", Response::HTTP_NOT_FOUND);
        }


        $template = TemplateLink::find($section->templateLink_id);

        if (!$template) {
            return $this->sendError("Not Found", "Template Link Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($template->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $result = $this->uploadSingle($request, "section", 'image');
            File::delete($section->image);
            $data['image'] = $result->getPathname();
        } else {
            $data['image'] = $section->image;
        }


        $section = $section->update($data);
        if (!$section) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $section = StrengthSection::where('id', $id)->first();
        $data = new SectionCollection(collect($section));
        return $this->sendResponse(data: $data, message: "Successfully updated ffData!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = StrengthSection::find($id);

        if (!$section) {
            return $this->sendError("Not Found", "Strength Section Not found", Response::HTTP_NOT_FOUND);
        }
        $template = TemplateLink::find($section->templateLink_id);

        if (!$template) {
            return $this->sendError("Not Found", "Template Link Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($template->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('delete-store', $store);

        if (!$section->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
