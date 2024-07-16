<?php

namespace App\Http\Controllers\Product\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\Image\ProductImageRequest;
use App\Http\Resources\Product\Image\ProductImageCollection;
use App\Models\Product\Product;
use App\Models\Product\Image\ProductImage;
use App\Models\Store\Store;




use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class ProductImageController extends Controller
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
        $product = ProductImage::paginate(10);
        $product = new ProductImageCollection($product);
        return $this->sendResponse($product, "Successfully get All Data");
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
    public function store(ProductImageRequest $request)
    {

        $store = Product::find($request->product_id);

        if (!$store) {
            return $this->sendError("Not Found", "Product Not found", Response::HTTP_NOT_FOUND);
        }

        if (!$request->hasFile("file")) {

            return $this->sendError("Not Found", "File Not found", Response::HTTP_NOT_FOUND);
        }

        $listfile = [];

        if (is_array($request->file('file'))) {

            $result = $this->uploadMulti($request, "product", 'file');
            foreach ($result as $r) {
                $listfile[] = ProductImage::create(["url" => $r->getPathname(), "product_id" => $request->product_id]);
            }
        } else {
            $result = $this->uploadSingle($request, "product", 'file');
            $listfile = ProductImage::create(["url" => $result->getPathname(), "product_id" => $request->product_id]);
        }


        // dd(is_array($request->file('file')) ? count($request->file('file')) : $request->file('file'));
        // $listUpload = $this->uploadMulti($request, $product);

        // $product->image = $listUpload;

        $data = new ProductImageCollection(collect($listfile));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $product = ProductImage::find($id);
        if (!$product) {
            return $this->sendError("Not Found", "Product Image Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new ProductImageCollection(collect($product));
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
    public function update(ProductImageRequest $request, string $id)
    {
        if (!$request->hasFile("file")) {
            return $this->sendError("Not Found", "File Not found", Response::HTTP_NOT_FOUND);
        }
        $image = ProductImage::find($id);
        if (!$image) {
            return $this->sendError("Not Found", "Product Image Not found", Response::HTTP_NOT_FOUND);
        }

        $product = Product::find($image->product_id);

        if (!$product) {
            return $this->sendError("Not Found", "Product Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($product->store_id);
        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);

        $result = $this->uploadSingle($request, "product", 'file');
        File::delete($image->url);

        $listfile = ProductImage::query()->update(["url" => $result->getPathname()]);

        if (!$listfile) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }

        $image = ProductImage::where('id', $id)->first();
        $data = new ProductImageCollection(collect($image));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $image = ProductImage::find($id);
        if (!$image) {
            return $this->sendError("Not Found", "Product Image Not found", Response::HTTP_NOT_FOUND);
        }

        $product = Product::find($image->product_id);

        if (!$product) {
            return $this->sendError("Not Found", "Product Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($product->store_id);
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
