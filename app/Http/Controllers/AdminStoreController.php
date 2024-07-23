<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function index()
    {
        $store = Store::with(["storeImages", "template", "products", "certifications", "testimonials", "employees"])->paginate(10);
        $data = new StoreCollection($store);
        return $this->sendResponse(message: "Successfully get All Data", data: $data);
    }
}
