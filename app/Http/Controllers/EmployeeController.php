<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;

use App\Models\Employee;


use App\Models\Store\Store;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\Gate;


class EmployeeController extends Controller
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
        $employee = Employee::paginate(10);
        $employee = new EmployeeCollection($employee);
        return $this->sendResponse($employee, "Successfully get All Data");
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
    public function store(EmployeeRequest $request)
    {

        $store = Store::find($request->store_id);

        if (!$store) {

            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }
        Gate::authorize('create-store', $store);

        $employee = Employee::create($request->all());


        $data = new EmployeeCollection(collect($employee));
        return $this->sendResponse(data: $data, message: "Successfully create new Data!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $employee = Employee::find($id);
        if (!$employee) {
            return $this->sendError("Not Found", "Employee Not found", Response::HTTP_NOT_FOUND);
        }
        $data = new EmployeeCollection(collect($employee));
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
    public function update(EmployeeRequest $request, string $id)
    {




        $employee = Employee::find($id);

        if (!$employee) {
            return $this->sendError("Not Found", "Employee Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($employee->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('update-store', $store);



        $employee = $employee->update($request->all());
        if (!$employee) {
            return $this->sendError("Bad Request", "Failed Update Data", Response::HTTP_BAD_REQUEST);
        }
        $employee = Employee::where('id', $id)->first();
        $data = new EmployeeCollection(collect($employee));
        return $this->sendResponse(data: $data, message: "Successfully updated Data!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $employee = Employee::find($id);

        if (!$employee) {
            return $this->sendError("Not Found", "Employee Not found", Response::HTTP_NOT_FOUND);
        }

        $store = Store::find($employee->store_id);

        if (!$store) {
            return $this->sendError("Not Found", "Store Not found", Response::HTTP_NOT_FOUND);
        }



        Gate::authorize('delete-store', $store);

        if (!$employee->delete()) {
            return $this->sendError("Bad Request", "Failed Delete Data", Response::HTTP_BAD_REQUEST);
        }

        return $this->sendResponse(message: "Successfully deleted Data!");
    }
}
