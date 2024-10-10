<?php

namespace App\Http\Controllers\Store\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Image\StoreImageRequest;
use App\Http\Resources\Product\Image\ProductImageCollection;
use App\Http\Resources\Store\Image\StoreImageCollection;
use App\Models\Product\Product;
use App\Models\Product\Image\ProductImage;
use App\Models\Store\Image\StoreImage;
use App\Models\Store\Store;




use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class StoreImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ["index", 'show']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(StoreImageRequest $request)
    {
        $limit = $request->query('limit', 10);
        $store = new StoreImage();
        if ($request->has('storeId')) {
            $storeId = $request->query('storeId');

            $store = $store->where('store_id',  $storeId);
        }
        if ($request->has('paginate')) {
            $page = $request->query('paginate');
            if ($page  === "true") {
                $store = $store->paginate($limit);
            } else {
                $store = $store->get();
            }
        } else {
            $store = $store->get();
        }


        $store = new StoreImageCollection($store);
        return $this->sendResponse($store, "Successfully get All Data");
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
    public function store(StoreImageRequest $request)
    {

        $store = Store::find($request->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        if (!$request->hasFile("file")) {
            return $this->sendError("Not Found", "File Not found", Response::HTTP_NOT_FOUND);
        }

        $listfile = [];

        if (is_array($request->file('file'))) {

            $result = $this->uploadMulti($request, "store", 'file');
            foreach ($result as $r) {
                $listfile[] = StoreImage::create(["url" => $r->getPathname(), "store_id" => $request->store_id]);
            }
        } else {
            $result = $this->uploadSingle($request, "store", 'file');
            $listfile = StoreImage::create(["url" => $result->getPathname(), "store_id" => $request->store_id]);
        }


        // dd(is_array($request->file('file')) ? count($request->file('file')) : $request->file('file'));
        // $listUpload = $this->uploadMulti($request, $product);

        // $product->image = $listUpload;

        $data = new StoreImageCollection(collect($listfile));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $store = StoreImage::find($id);
        if (!$store) {
            return $this->sendError("Not Found", "Store Image Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new StoreImageCollection(collect($store));
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
    public function update(StoreImageRequest $request, string $id)
    {
        if (!$request->hasFile("file")) {
            return $this->sendError("Not Found", "File Not found", Response::HTTP_NOT_FOUND);
        }
        $image = StoreImage::query()->find($id);

        if (!$image) {
            return $this->sendError("Not Found", "Store Image Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($image->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);

        $result = $this->uploadSingle($request, "store", 'file');
        File::delete($image->url);

        $listfile = StoreImage::where('id', $id)->update(["url" => $result->getPathname()]);

        if (!$listfile) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }

        $image = StoreImage::where('id', $id)->first();
        $data = new StoreImageCollection(collect($image));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $image = StoreImage::find($id);
        if (!$image) {
            return $this->sendError("Not Found", "Store Image Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($image->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('delete-store', $store);

        if (!$image->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }
        File::delete($image->url);

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
