<?php
namespace App\Http\Controllers; use App\Models\{Staff,Service,User}; use Illuminate\Http\Request;
class StaffController extends Controller {
 public function index(){return view('staff.index',['staffMembers'=>Staff::with(['user','services'])->orderBy('full_name')->paginate(12),'services'=>Service::where('active',true)->get(),'users'=>User::where('role','stylist')->get()]);}
 public function store(Request $r){$d=$this->data($r);$services=$d['services']??[];unset($d['services']);$s=Staff::create($d);$s->services()->sync($services);return back()->with('success','Staff member added.');}
 public function update(Request $r,Staff $staff){$d=$this->data($r,$staff);$services=$d['services']??[];unset($d['services']);$staff->update($d);$staff->services()->sync($services);return back()->with('success','Staff profile updated.');}
 public function destroy(Staff $staff){if($staff->appointments()->exists())return back()->with('error','Staff has appointment history. Deactivate instead.');$staff->delete();return back()->with('success','Staff removed.');}
 private function data(Request $r,?Staff $staff=null){return $r->validate(['user_id'=>'nullable|exists:users,id|unique:staff,user_id,'.($staff?->id??'NULL'),'full_name'=>'required|string|max:120','phone'=>'nullable|string|max:30','email'=>'nullable|email|max:150','specialty'=>'nullable|string|max:120','commission_percent'=>'required|numeric|min:0|max:100','active'=>'nullable|boolean','notes'=>'nullable|string','services'=>'nullable|array','services.*'=>'exists:services,id']);}
}
