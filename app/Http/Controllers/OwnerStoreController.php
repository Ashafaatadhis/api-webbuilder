<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRequest;
use App\Http\Resources\Store\StoreCollection;
use App\Models\Store\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role:store_owner');
    }

    public function index(StoreRequest $request)
    {
        $limit = $request->query('limit', 10);
        $user = Auth::user();
        $store = Store::with(["storeImages", "templateLink", "products", "certifications", "testimonials", "employees"])->where(column: "user_id", operator: "=", value: $user->id)->paginate($limit);
        $data = new StoreCollection($store);
        return $this->sendResponse(message: "Successfully get All Data", data: $data);
    }
}
