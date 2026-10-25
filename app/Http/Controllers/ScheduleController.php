<?php
namespace App\Http\Controllers; use App\Models\{Staff,StaffSchedule}; use Illuminate\Http\Request;
class ScheduleController extends Controller {
 public function index(){return view('staff.schedule',['staffMembers'=>Staff::with('schedules')->where('active',true)->orderBy('full_name')->get()]);}
 public function store(Request $r){$d=$r->validate(['staff_id'=>'required|exists:staff,id','day_of_week'=>'required|integer|min:0|max:6','start_time'=>'required|date_format:H:i','end_time'=>'required|date_format:H:i|after:start_time']);StaffSchedule::updateOrCreate(['staff_id'=>$d['staff_id'],'day_of_week'=>$d['day_of_week']],$d);return back()->with('success','Schedule saved.');}
 public function destroy(StaffSchedule $schedule){$schedule->delete();return back()->with('success','Schedule removed.');}
}
