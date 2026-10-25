<?php
namespace App\Http\Controllers; use App\Models\Service; use Illuminate\Http\Request; use Illuminate\Validation\Rule;
class ServiceController extends Controller {
 public function index(){return view('services.index',['services'=>Service::orderBy('category')->orderBy('name')->paginate(20)]);}
 public function store(Request $r){Service::create($this->data($r));return back()->with('success','Service created.');}
 public function update(Request $r,Service $service){$service->update($this->data($r));return back()->with('success','Service updated.');}
 public function destroy(Service $service){if($service->appointments()->exists())return back()->with('error','Service is used in appointments. Deactivate it instead.');$service->delete();return back()->with('success','Service deleted.');}
 private function data(Request $r){$d=$r->validate(['name'=>'required|string|max:100','category'=>'nullable|string|max:60','duration_minutes'=>'required|integer|min:15|max:480','price'=>'required|numeric|min:0','active'=>'nullable|boolean']);$d['active']=$r->boolean('active');return $d;}
}
