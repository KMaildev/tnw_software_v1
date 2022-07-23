<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::orderBy('sort_id', 'ASC')->get();
        return view('hr.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('title')->get();
        $roles = Role::all();
        return view('hr.employee.create', compact('departments', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsers $request)
    {
        if ($request->hasFile('employee_photo')) {
            $emp_photo = $request->file('employee_photo');
            $employee_photo = $emp_photo->store('public/employee_photo');
        }

        $employee = new User();
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->password = Hash::make($request->password);
        $employee->employment_type = $request->employment_type;
        $employee->join_date = $request->join_date;
        $employee->contact_person = $request->contact_person;
        $employee->emergency_contact = $request->emergency_contact;
        $employee->employee_photo = $employee_photo ?? '';
        $employee->department_id = $request->department_id;
        $employee->save();
        $employee->syncRoles($request->roles);
        return redirect()->back()->with('success', 'Your processing has been completed.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $old_roles = $employee->roles->pluck('id')->toArray();
        $departments = Department::orderBy('title')->get();
        $roles = Role::all();
        return view('hr.employee.edit', compact('employee', 'old_roles', 'departments', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsers $request, $id)
    {
        if ($request->hasFile('employee_photo')) {
            $emp_photo = $request->file('employee_photo');
            $employee_photo = $emp_photo->store('public/employee_photo');
        }

        $employee = User::findOrFail($id);
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->password = $request->password ? Hash::make($request->password) : $employee->password;
        $employee->employment_type = $request->employment_type;
        $employee->join_date = $request->join_date;
        $employee->contact_person = $request->contact_person;
        $employee->emergency_contact = $request->emergency_contact;
        $employee->employee_photo = $employee_photo ?? '';

        $employee->department_id = $request->department_id;
        $employee->update();
        $employee->syncRoles($request->roles);
        return redirect()->back()->with('success', 'Your processing has been completed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function employeeSortable(Request $request)
    {
        $users = User::all();

        foreach ($users as $user) {
            foreach ($request->order as $order) {
                if ($order['id'] == $user->id) {
                    $user->sort_id = $order['position'];
                    $user->update();
                }
            }
        }
        return response('Update Successfully.', 200);
    }
}
