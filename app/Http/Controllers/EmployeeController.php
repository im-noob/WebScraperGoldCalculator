<?php

namespace App\Http\Controllers;

use App\EmployeeModel;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('List',["data"=>EmployeeModel::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Checking Validation 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
        ]);

        $employee = new EmployeeModel;

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();

        return redirect()->route('Employee.index')->with('success','Inserted Record Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeModel  $employeeModel
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeModel $employeeModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeModel  $employeeModel
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeModel $employeeModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeModel  $employeeModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeModel $employeeModel)
    {
        //Checking Validation 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);


        $employeeModel->first_name = $request->first_name;
        $employeeModel->last_name = $request->last_name;
        $employeeModel->email = $request->email;
        $employeeModel->phone = $request->phone;

        $employeeModel->save();

        return redirect()->route('Employee.index')->with('success','Record Updated Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeModel  $employeeModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeModel $employeeModel)
    {
        echo($employeeModel->delete());

        return redirect()->route('Employee.index')->with('success','Deleted SuccessFully.');
    }
}
