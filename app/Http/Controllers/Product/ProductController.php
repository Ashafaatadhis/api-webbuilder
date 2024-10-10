<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;

use App\Http\Resources\Product\ProductCollection;

use App\Models\Product\Product;


use App\Models\Store\Store;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\Gate;


class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ["index", 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductRequest $request)
    {
        $limit = $request->query('limit', 10);
        $product = Product::with(["productImages"]);


        if ($request->has('storeId')) {
            $storeId = $request->query('storeId');

            $product = $product->where('store_id',  $storeId);
        }

        if ($request->has('storeOwnerId')) {
            $storeOwnerId = $request->query('storeOwnerId');
            $product = $product->orWhereHas('store', function ($query) use ($storeOwnerId) {
                $query->where('user_id', $storeOwnerId);
            });
        }



        if ($request->has('paginate')) {
            $page = $request->query('paginate');
            if ($page  === "true") {
                $product = $product->paginate($limit);
            } else {
                $product = $product->get();
            }
        } else {
            $product = $product->get();
        }

        $product = new ProductCollection($product);
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
    public function store(ProductRequest $request)
    {

        $store = Store::find($request->store_id);

        if (!$store) {

            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('create-store', $store);

        $product = Product::create($request->all());

        // dd(is_array($request->file('file')) ? count($request->file('file')) : $request->file('file'));
        // $listUpload = $this->uploadMulti($request, $product);

        // $product->image = $listUpload;

        $data = new ProductCollection(collect($product));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $product = Product::with(["productImages"])->find($id);
        if (!$product) {
            return $this->sendError("Not Found", "Product Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new ProductCollection(collect($product));
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
    public function update(ProductRequest $request, string $id)
    {




        $product = Product::find($id);

        if (!$product) {
            return $this->sendError("Not Found", "Product Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($product->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);



        $product = $product->update($request->all());
        if (!$product) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $product = Product::where('id', $id)->first();
        $data = new ProductCollection(collect($product));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::find($id);
        if (!$product) {
            return $this->sendError("Not Found", "Product Not found", Response::HTTP_NOT_FOUND);
        }
        $store = Store::find($product->store_id);
        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }


        Gate::authorize('delete-store', $store);

        if (!$product->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
