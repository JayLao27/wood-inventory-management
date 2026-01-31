<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
	public function index() {
		$customers = Customer::all();
		return view('customers.index', compact('customers'));
	}

	public function store(Request $request) {
		$request->validate([
			'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s\'-]+$/',
			'customer_type' => 'required|in:Retail,Contractor,Wholesale',
			'phone' => ['nullable','regex:/^[0-9]{0,12}$/','max:12'],
			'email' => 'nullable|email|max:255|unique:customers,email',
			'address' => 'nullable|string|max:255',
		]);
		Customer::create($request->only('name','customer_type','phone','email','address'));
		return redirect()->route('sales-orders.index')->with('success', 'Customer added.');
	}

	public function update(Request $request, Customer $customer) {
		$request->validate([
			'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s\'-]+$/',
			'customer_type' => 'required|in:Retail,Contractor,Wholesale',
			'phone' => ['nullable','regex:/^[0-9]{0,12}$/','max:12'],
			'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
			'address' => 'nullable|string|max:255',
		]);
		$customer->update($request->only('name','customer_type','phone','email','address'));
		return redirect()->route('sales-orders.index')->with('success', 'Customer updated.');
	}

	public function delete(Customer $customer) {
		$customer->delete();
		return redirect()->route('sales-orders.index')->with('success', 'Customer deleted.');
	}
}
