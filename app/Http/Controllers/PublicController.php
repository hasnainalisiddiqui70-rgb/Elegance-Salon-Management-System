<?php
namespace App\Http\Controllers; use App\Models\{Service,Feedback,Staff}; use Illuminate\Http\Request;
class PublicController extends Controller {
 public function home(){return view('public.home',['services'=>Service::where('active',true)->orderBy('category')->limit(8)->get(),'staffMembers'=>Staff::where('active',true)->limit(4)->get()]);}
 public function contact(){return view('public.contact');}
 public function feedback(){return view('public.feedback');}
 public function submitFeedback(Request $r){$d=$r->validate(['name'=>'required|string|max:120','email'=>'nullable|email|max:150','rating'=>'required|integer|min:1|max:5','message'=>'required|string|min:10|max:2000']);Feedback::create($d);return back()->with('success','Thank you — your feedback has been submitted.');}
}
