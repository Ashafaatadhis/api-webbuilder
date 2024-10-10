<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRequest;
use App\Http\Resources\Store\StoreCollection;
use App\Models\Store\Store;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role:administrator');
    }

    public function index(StoreRequest $request)
    {
        $limit = $request->query('limit', 10);
        $store = Store::with(["storeImages", "templateLink", "products", "certifications", "testimonials", "employees"])->paginate($limit);
        $data = new StoreCollection($store);
        return $this->sendResponse(message: "Successfully get All Data", data: $data);
    }
}
