<?php
namespace App\Http\Controllers; use App\Models\Client; use Illuminate\Http\Request;
class ClientController extends Controller {
 public function index(Request $r){$q=Client::query()->withCount('appointments');if($s=$r->q)$q->where(fn($x)=>$x->where('full_name','like',"%$s%")->orWhere('phone','like',"%$s%")->orWhere('email','like',"%$s%"));return view('clients.index',['clients'=>$q->latest()->paginate(12)->withQueryString()]);}
 public function create(){return view('clients.form',['client'=>new Client]);}
 public function store(Request $r){Client::create($this->data($r));return redirect()->route('clients.index')->with('success','Client added.');}
 public function show(Client $client){$client->load(['appointments.service','appointments.staff']);return view('clients.show',compact('client'));}
 public function edit(Client $client){return view('clients.form',compact('client'));}
 public function update(Request $r,Client $client){$client->update($this->data($r));return redirect()->route('clients.show',$client)->with('success','Client updated.');}
 public function destroy(Client $client){if($client->appointments()->exists())return back()->with('error','Client has appointment history and cannot be deleted.');$client->delete();return redirect()->route('clients.index')->with('success','Client deleted.');}
 private function data(Request $r){return $r->validate(['full_name'=>'required|string|max:120','phone'=>'required|string|max:30','email'=>'nullable|email|max:150','gender'=>'nullable|string|max:20','birthday'=>'nullable|date','preferences'=>'nullable|string','notes'=>'nullable|string']);}
}
