<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Customers;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomersResource;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return CustomersResource::collection(Customers::latest()->paginate(5));
        return new CustomerCollection(Customers::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:customers,email',
            'phone'     => 'required|numeric',
            'address'   => 'required',
            'total'     => 'required|numeric'
        ],
        [
            'name.required' => 'Name not Empty!',
            'email.required' => 'Email not Empty',
            'phone.required' => 'Phone not Empty!',
            'address.required' => 'Address not Empty!',
            'total.required' => 'Total not Empty!',
            'email.email' => 'Wrong format email!',
            'email.unique' => 'Email already exist!',
            'phone.numeric' => 'Is not a number',
            'total.numeric' => 'Is not a number !'
        ]);
        $customer = new Customers;
        
        $customer->name     = $request->name;
        $customer->email    = $request->email;
        $customer->phone    = $request->phone;
        $customer->address  = $request->address;
        $customer->total    = $request->total;
        $customer->save();
        return new CustomersResource($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CustomersResource(Customers::findOrfail($id));
    }

    public function search($field, $query){
        return new CustomerCollection(Customers::where($field, 'LIKE', "%$query%")->latest()->paginate(5));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:customers,email,'.$id,
            'phone'     => 'required|numeric',
            'address'   => 'required',
            'total'     => 'required|numeric'
        ],
        [
            'name.required' => 'Name not Empty!',
            'email.required' => 'Email not Empty',
            'phone.required' => 'Phone not Empty!',
            'address.required' => 'Address not Empty!',
            'total.required' => 'Total not Empty!',
            'email.email' => 'Wrong format email!',
            'email.unique' => 'Email already exist!',
            'phone.numeric' => 'Is not a number',
            'total.numeric' => 'Is not a number !'
        ]);
        $customer = Customers::findOrfail($id);
        
        $customer->name     = $request->name;
        $customer->email    = $request->email;
        $customer->phone    = $request->phone;
        $customer->address  = $request->address;
        $customer->total    = $request->total;
        $customer->update();
        return new CustomersResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customers::findOrfail($id);
        $customer->delete();
        return new CustomersResource($customer);

    }
}
