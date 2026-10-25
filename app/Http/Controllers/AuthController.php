<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {
 public function showLogin(){if(Auth::check()) return redirect()->route('dashboard'); return view('auth.login');}
 public function login(Request $r){$cred=$r->validate(['email'=>'required|email','password'=>'required|string']); if(Auth::attempt($cred,$r->boolean('remember'))){if(!Auth::user()->active){Auth::logout();return back()->withErrors(['email'=>'This account is inactive.'])->onlyInput('email');}$r->session()->regenerate();return redirect()->intended(route('dashboard'));} return back()->withErrors(['email'=>'Invalid email or password.'])->onlyInput('email');}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('login')->with('success','Signed out successfully.');}
}
