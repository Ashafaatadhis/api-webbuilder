<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function index()
    {
        $user = Auth::user();
        $store = Store::with(["storeImages", "template", "products", "certifications", "testimonials", "employees"])->where(column: "user_id", operator: "=", value: $user->id)->paginate(10);
        $data = new StoreCollection($store);
        return $this->sendResponse(message: "Successfully get All Data", data: $data);
    }
}
