<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeCollection;
use App\Models\Employee;
use App\Models\Product\Product;
use App\Models\Store\Store;
use App\Models\Template\Template;
use App\Models\Template\TemplateLink;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->role === "store_owner") {
            $totalEmployee = Employee::whereHas('store', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();
            $totalProduct = Product::whereHas('store', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();
            $totalStore = Store::where('user_id', $user->id)->count();

            $response = [
                'totalEmployees' => $totalEmployee,
                'totalProducts' => $totalProduct,
                'totalStores' => $totalStore,
            ];
        } elseif ($user->role === "administrator") {
            $totalStoreOwner = User::where("role", "store_owner")->count();
            $totalTemplate = Template::count();
            $totalTemplateLink = TemplateLink::count();

            $response = [
                'totalStoreOwner' => $totalStoreOwner,
                'totalTemplate' => $totalTemplate,
                'totalTemplateLink' => $totalTemplateLink,
            ];
        }

        $total = new EmployeeCollection($response);
        return $this->sendResponse($total, "Successfully get Data");
    }
}
