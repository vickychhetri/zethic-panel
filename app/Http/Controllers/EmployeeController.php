<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeEmployeeEmail;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|JsonResponse
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('view employee')) {
            return view('admin.denied');
        }

        $employees = User::role('employee')->paginate(10);

        if ($request->ajax()) {
            return response()->json(['employees' => $employees]);
        }

        return view('admin.employee.index', compact('employees'));
    }


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('add employee')) {
            return view('admin.denied');
        }

        return view('admin.employee.create');
    }


    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('add employee')) {
            return view('admin.denied');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'employee_id' => 'required',
            'password' => 'required|min:8|confirmed',
            'building_no' => 'nullable',
            'street_name' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'pincode' => 'nullable',
        ]);

        #IF VALIDATION FAIL SEND RESPONSE
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()->first()
            ], 400);
        }
        try {


            // Assuming a successful validation, create the store
            $employee = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'password' => Hash::make($request->password),
            ]);

            $employee->assignRole('employee');
            $userAddress = new UserAddress();
            $userAddress->user_id = $employee->id;
            $userAddress->building_no = $request->building_no;
            $userAddress->street_name = $request->street_name;
            $userAddress->city = $request->city;
            $userAddress->state = $request->state;
            $userAddress->country = $request->country;
            $userAddress->pincode = $request->pincode;
            $userAddress->save();
            // Send Welcome Email
            SendWelcomeEmployeeEmail::dispatch($employee);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully!'
        ], 200);

    }


    /**
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application|never
     */
    public function show(string $id)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('view employee')) {
            return view('admin.denied');
        }

        $employee = User::with('user_address')->find($id);
        if (!$employee) {
            return abort(404);
        }
        return view('admin.employee.view', compact('employee'));
    }


    /**
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application|never
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('edit employee')) {
            return view('admin.denied');
        }
        $employee = User::with('user_address')->find($id);
        if (!$employee) {
            return abort(404);
        }
        return view('admin.employee.edit', compact('employee'));
    }


    /**
     * @param Request $request
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application|JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('edit employee')) {
            return view('admin.denied');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'employee_id' => 'required',
            'password' => 'nullable|min:8|confirmed',
            'building_no' => 'nullable',
            'street_name' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'pincode' => 'nullable',
        ]);

        #IF VALIDATION FAIL SEND RESPONSE
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()->first()
            ], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Employee record not found!, Contact Administrator for more detail"
            ], 404);
        }

        try {

            // Assuming a successful validation, create the store
            $input = array();
            if ($request->name) {
                $input["name"] = $request->name;
            }
            if ($request->email) {
                $input["email"] = $request->email;
            }
            if ($request->employee_id) {
                $input["employee_id"] = $request->employee_id;
            }
            if ($request->password) {
                $input["password"] = Hash::make($request->password);
            }
            $employee = $user->update($input);

            $userAddress = UserAddress::where('user_id', $id)->first();
            if ($userAddress) {
                $userAddress->building_no = $request->building_no;
                $userAddress->street_name = $request->street_name;
                $userAddress->city = $request->city;
                $userAddress->state = $request->state;
                $userAddress->country = $request->country;
                $userAddress->pincode = $request->pincode;
                $userAddress->save();
            }

        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully!'
        ], 200);
    }

}
