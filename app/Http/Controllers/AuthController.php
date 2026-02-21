<?php
	

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\CustomValidAltcha;
	
class AuthController extends Controller
{
	public function showLogin()
	{
		if (Auth::check()) {
			return redirect($this->getHomeRoute());
		}
		return view('auth::Login');
	}

	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => 'required|email',
			'password' => 'required|string',
			'altcha_payload' => ['required', new CustomValidAltcha()],
		]);

		if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
			$request->session()->regenerate();

			return redirect()->intended($this->getHomeRoute());
		}

		return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
	}

	/**
	 * Get the home route based on user role
	 */
	private function getHomeRoute(): string
	{
		$user = Auth::user();
		
		return match($user->role) {
			'admin' => route('dashboard'),
			'inventory_clerk' => route('inventory'),
			'procurement_officer' => route('procurement'),
			'workshop_staff' => route('production'),
			'sales_clerk' => route('sales'),
			'accounting_staff' => route('dashboard'),
			default => route('dashboard'),
		};
	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('login');
	}
}
