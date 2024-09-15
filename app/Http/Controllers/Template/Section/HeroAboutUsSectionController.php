<?php

namespace App\Http\Controllers\Template\Section;

use App\Http\Controllers\Controller;

use App\Http\Requests\Template\Section\HeroAboutUsSectionRequest;
use App\Http\Resources\Template\SectionCollection;
use App\Models\Store\Store;

use App\Models\Template\Section\HeroAboutUsSection;
use App\Models\Template\Template;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Gate;

class HeroAboutUsSectionController extends Controller
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
        $section = HeroAboutUsSection::paginate(10);
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
    public function store(HeroAboutUsSectionRequest $request)
    {



        $template = Template::find($request->template_id);

        if (!$template) {
            return $this->sendError("Not Found", "Template Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($template->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('create-store', $store);
        //  unique store_id


        $data = $request->all();


        $section = HeroAboutUsSection::create($data);

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
        $section = HeroAboutUsSection::find($id);

        if (!$section) {
            return $this->sendError("Not Found", "Hero About Us Section Not found", Response::HTTP_NOT_FOUND);
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
    public function update(HeroAboutUsSectionRequest $request, string $id)
    {


        $section = HeroAboutUsSection::find($id);

        if (!$section) {
            return $this->sendError("Not Found", "Hero About Us Section Not found", Response::HTTP_NOT_FOUND);
        }

        $template = Template::find($section->template_id);

        if (!$template) {
            return $this->sendError("Not Found", "Template Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($template->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);
        $data = $request->all();



        $section = $section->update($data);
        if (!$section) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $section = HeroAboutUsSection::where('id', $id)->first();
        $data = new SectionCollection(collect($section));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = HeroAboutUsSection::find($id);

        if (!$section) {
            return $this->sendError("Not Found", "Hero About Us Section Not found", Response::HTTP_NOT_FOUND);
        }
        $template = Template::find($section->template_id);
        if (!$template) {
            return $this->sendError("Not Found", "Template Not found", Response::HTTP_NOT_FOUND);
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
