<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\TemplateRequest;
use App\Http\Resources\Template\TemplateCollection;

use App\Models\Template\Template;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class TemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ["index", 'show']]);
        $this->middleware('role:administrator', ['except' => ["index", 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TemplateRequest $request)
    {
        $categoryId = $request->route("slug");

        $template = Template::with(["templateCategory"]);
        if ($request->has('search')) {
            $search = $request->query('search');
            $template->where('name', 'like', '%' . $search . '%'); // Adjust the column name as needed
        }
        if ($categoryId) {
            $template->where("templateCategory_id", $categoryId);
        }

        if ($request->has('paginate')) {
            $page = $request->query('paginate');
            if ($page) {
                $template = $template->paginate(10);
            }
        }
        $template = $template->get();

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

        $result = $this->uploadSingle($request, "template", 'image');

        $data = $request->all();

        $data['image'] = $result->getPathname();

        $template = Template::create($data);

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

        $template = Template::with(["templateCategory"])->find($id);
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
        $data = $request->all();

        if ($request->hasFile('image')) {
            $result = $this->uploadSingle($request, "template", 'image');
            File::delete($template->image);
            $data['image'] = $result->getPathname();
        } else {
            $data['image'] = $template->image;
        }

        $template = $template->update($data);
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


        if (!$template->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }

        File::delete($template->image);

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
