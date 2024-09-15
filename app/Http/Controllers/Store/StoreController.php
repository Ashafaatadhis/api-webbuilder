<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRequest;
use App\Http\Resources\Store\StoreCollection;
use App\Http\Resources\StoreResource;
use App\Models\Store\Store;
use App\Models\User;

use Exception;
use Faker\Test\Provider\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ["index", 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(StoreRequest $request)
    {
        $store = Store::with(["storeImages", "template", "products", "products.productImages", "certifications", "testimonials", "employees" => function ($query) {
            $query->orderBy('level', 'asc');
        }]);
        if ($request->has('search')) {
            $search = $request->query('search');
            $store->where('name', 'like', '%' . $search . '%')->orWhereHas('products', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }); // Adjust the column name as needed
        }
        $store = $store->paginate(10);
        $data = new StoreCollection($store);
        return $this->sendResponse(message: "Successfully get All Data", data: $data);
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
    public function store(StoreRequest $request)
    {

        $user = Auth::user();


        if (!User::query()->where("id", $user->id)->exists()) {
            return $this->sendError("Not Found", "User Not found", Response::HTTP_NOT_FOUND);
            // return $this->sendError("User not found", status: Response::HTTP_NOT_FOUND);
        }
        // add image

        $result = $this->uploadSingle($request, "store", 'logo');

        $data = $request->all();

        $data['logo'] = $result->getPathname();

        $data["user_id"] = $user->id;
        $store = Store::query()->create($data);

        $data = new StoreCollection(collect($store));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $store = Store::with(["storeImages", "template", "products.productImages", "certifications", "testimonials", "employees" => function ($query) {
            $query->orderBy('level', 'asc');
        }])->find($id);
        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new StoreCollection(collect($store));
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
    public function update(StoreRequest $request, string $id)
    {

        $user = Auth::user();


        $store = Store::find($id);
        if (!User::query()->where("id", $user->id)->exists()) {
            return $this->sendError("Not Found", "User Not found", Response::HTTP_NOT_FOUND);
        }

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }


        Gate::authorize('update-store', $store);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $result = $this->uploadSingle($request, "store", 'logo');
            File::delete($store->logo);
            $data['logo'] = $result->getPathname();
        } else {
            $data['logo'] = $store->logo;
        }

        $data["user_id"] = $user->id;

        // if want slug regenerate after update
        // $store->slug = null;

        $store = $store->update($data);
        if (!$store) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $store = Store::where('id', $id)->first();
        $data = new StoreCollection(collect($store));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $store = Store::find($id);
        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);

        if (!$store->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }
        File::delete($store->logo);
        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
