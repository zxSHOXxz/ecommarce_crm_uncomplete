<?php

namespace App\Http\Controllers\Backend;

use App\Models\Customer;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class BackendCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers =  Customer::where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%')->orWhere('phone', 'LIKE', '%' . $request->q . '%')->orWhere('email', 'LIKE', '%' . $request->q . '%');
        })->withCount(['logs'])->with(['roles'])->orderBy('last_activity', 'DESC')->orderBy('id', 'DESC')->paginate();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'customer')->get();
        return view('admin.customers.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "nullable|max:190",
            'phone' => "nullable|max:190",
            'bio' => "nullable|max:5000",
            'shiping_data' => "nullable|max:5000",
            'customer_discount' => "nullable",
            'customer_type' => "required|in:b2b,b2c",
            'company_name' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_address' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'vat_number' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_country' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'b2b_files' => $request->input('customer_type') == 'b2b' ? 'nullable|array' : 'nullable',
            'email' => "required|unique:customers,email",
            'password' => "required|min:8|max:190"
        ]);

        if ($request->input('customer_type') == 'b2c') {
            $customer = Customer::create([
                "name" => $request->name,
                "phone" => $request->phone,
                "bio" => $request->bio,
                "customer_type" => $request->customer_type,
                "blocked" => false,
                "email" => $request->email,
                "shiping_data" => $request->shiping_data,
                "customer_discount" => $request->customer_discount,
                "password" => Hash::make($request->password),
            ]);
        } else {
            $customer = Customer::create([
                "shiping_data" => $request->shiping_data,
                "customer_discount" => $request->customer_discount,
                "name" => $request->name,
                "phone" => $request->phone,
                "bio" => $request->bio,
                "customer_type" => $request->customer_type,
                "vat_number" => $request->vat_number,
                "company_address" => $request->company_address,
                "company_name" => $request->company_name,
                "company_country" => $request->company_country,
                "blocked" => true,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
        }

        $customer->assignRole(Role::findByName('normal_customer', 'customer'));

        if ($request->hasFile('b2b_files')) {
            $uploadedFiles = $request->file('b2b_files');
            $filePaths = [];

            foreach ($uploadedFiles as $file) {
                $filePath = $file->store('public/customer_files/' . $customer->id); // Adjust path as needed
                $filePaths[] = $filePath;
            }

            $customer->b2b_files = json_encode($filePaths); // Encode file paths as JSON
            $customer->save();
        }

        if ($request->hasFile('avatar')) {
            $avatar = $customer->addMedia($request->avatar)->toMediaCollection('avatar');
            $customer->update(['avatar' => $avatar->id . '/' . $avatar->file_name]);
        }

        toastr()->success('Done Added Customer', 'Succesfully');
        return redirect()->route('admin.customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $roles = Role::where('guard_name', 'customer')->get();
        return view('admin.customers.edit', compact('customer', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => "nullable|max:190",
            'phone' => "nullable|max:190",
            'bio' => "nullable|max:5000",
            'shiping_data' => "nullable|max:5000",
            'customer_discount' => "nullable",
            'customer_type' => "required|in:b2b,b2c",
            'company_name' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_address' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'vat_number' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'company_country' => $request->input('customer_type') == 'b2b' ? 'required|max:190' : 'nullable',
            'b2b_files' => $request->input('customer_type') == 'b2b' ? 'nullable|array' : 'nullable',
            'email' => "required|unique:customers,email," . $customer->id,
            'password' => "nullable|min:8|max:190"
        ]);

        if ($request->input('customer_type') == 'b2c') {
            $customer->update([
                "name" => $request->name,
                "phone" => $request->phone,
                "bio" => $request->bio,
                "customer_type" => $request->customer_type,
                "blocked" => $request->blocked,
                "email" => $request->email,
                "shiping_data" => $request->shiping_data,
                "customer_discount" => $request->customer_discount,
                "password" => Hash::make($request->password),
            ]);
        } else {
            $customer->update([
                "shiping_data" => $request->shiping_data,
                "customer_discount" => $request->customer_discount,
                "name" => $request->name,
                "phone" => $request->phone,
                "bio" => $request->bio,
                "customer_type" => $request->customer_type,
                "vat_number" => $request->vat_number,
                "company_address" => $request->company_address,
                "company_name" => $request->company_name,
                "company_country" => $request->company_country,
                "blocked" => $request->blocked,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
        }

        $customer->syncRoles([7]);

        if ($request->hasFile('b2b_files')) {
            $uploadedFiles = $request->file('b2b_files');
            $filePaths = [];

            foreach ($uploadedFiles as $file) {
                $filePath = $file->store('public/customer_files/' . $customer->id); // Adjust path as needed
                $filePaths[] = $filePath;
            }

            $customer->b2b_files = json_encode($filePaths); // Encode file paths as JSON
            $customer->save();
        }

        if ($request->hasFile('avatar')) {
            $avatar = $customer->addMedia($request->avatar)->toMediaCollection('avatar');
            $customer->update(['avatar' => $avatar->id . '/' . $avatar->file_name]);
        }

        toastr()->success('Customer updated', 'Successfully procces');
        return redirect()->route('admin.customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if (!auth()->user()->can('customers-delete')) abort(403);
        $customer->delete();
        toastr()->success('تم حذف المستخدم بنجاح', 'عملية ناجحة');
        return redirect()->route('admin.customers.index');
    }
}
