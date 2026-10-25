<?php
namespace App\Http\Controllers; use App\Models\{User,Setting,Feedback}; use Illuminate\Http\Request; use Illuminate\Support\Facades\Hash; use Illuminate\Validation\Rule;
class AdminController extends Controller {
 public function users(){return view('admin.users',['users'=>User::orderBy('name')->paginate(15)]);}
 public function storeUser(Request $r){$d=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|max:150|unique:users,email','password'=>'required|string|min:8','role'=>'required|in:admin,receptionist,stylist']);$d['password']=Hash::make($d['password']);$d['active']=true;User::create($d);return back()->with('success','User account created.');}
 public function updateUser(Request $r,User $user){$d=$r->validate(['name'=>'required|string|max:100','email'=>['required','email','max:150',Rule::unique('users')->ignore($user->id)],'role'=>'required|in:admin,receptionist,stylist','active'=>'nullable|boolean','password'=>'nullable|string|min:8']);$d['active']=$r->boolean('active');if(empty($d['password']))unset($d['password']);else $d['password']=Hash::make($d['password']);$user->update($d);return back()->with('success','User updated.');}
 public function settings(){return view('admin.settings',['allSettings'=>Setting::pluck('value','key')]);}
 public function saveSettings(Request $r){$d=$r->validate(['salon_name'=>'required|string|max:120','salon_email'=>'required|email|max:150','salon_phone'=>'required|string|max:40','salon_address'=>'required|string|max:255','business_hours'=>'required|string|max:255']);foreach($d as $k=>$v)Setting::updateOrCreate(['key'=>$k],['value'=>$v]);return back()->with('success','Salon settings saved.');}
 public function feedback(){return view('admin.feedback',['feedbackItems'=>Feedback::latest()->paginate(20)]);}
}
