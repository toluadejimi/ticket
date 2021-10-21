<?php

namespace App\Http\Controllers\Admin;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

use App\Role;
use App\User;
use App\Tickets;
use App\Files;
use App\Replies;
use App\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::Paginate(15);
        return view('admin.clients.index',compact('customers'));
    }

    /**
     * Create new resource.
     */
    public function create(){
        return view('admin.clients.add');
    }

    /**
     * Add new resource to database.
     */
    public function store(Request $request){
        $this->validate($request, [
            // 'name' => 'required|max:32',
            // 'username' => 'required|max:100|unique:users',
            // 'email' => 'required|email|max:100|unique:users',
            // // 'password' => 'required|min:6',
        ]);
        $customer  = new Customer();
        $customer->customer_name = $request->customer_name;
        $customer->phone_no = $request->phone_no;
        $customer->email = $request->email;
        // $user->password = bcrypt($request->password);
        $customer->save();
        // $role = Role::where('name', 'client')->first();
        // $user->roles()->attach($role->id);
        return redirect::to('admin/clients')->withMessage('New Customer has been added');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.clients.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'customer_name' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
        ]);
        $customer = Customer::find($id);
        $customer->customer_name = $request->customer_name;
        $customer->phone_no = $request->phone_no;
        $customer->email = $request->email;

        $customer->save();

        return redirect::to('admin/clients')->withMessage('Record has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       Customer::where('customer_id', $id)->delete();
        Customer::find($id)->delete();
        return 'success';
    }
}
