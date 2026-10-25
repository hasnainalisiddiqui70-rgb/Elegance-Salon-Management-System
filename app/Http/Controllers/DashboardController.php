<?php
namespace App\Http\Controllers;
use App\Models\{Appointment,Client,InventoryItem,Payment,Staff,Service};
class DashboardController extends Controller {
 public function index(){
  $u=auth()->user(); $q=Appointment::with(['client','service','staff'])->whereDate('appointment_date',today());
  if($u->role==='stylist'){ $sid=$u->staff?->id; $q->where('staff_id',$sid ?: 0); }
  $todayAppointments=$q->orderBy('start_time')->get();
  $stats=['todayAppointments'=>$todayAppointments->count(),'clients'=>Client::count(),'activeStaff'=>Staff::where('active',true)->count(),'lowStock'=>InventoryItem::whereColumn('quantity','<=','reorder_level')->count(),'monthlyRevenue'=>Payment::where('status','paid')->whereBetween('paid_at',[now()->startOfMonth(),now()->endOfMonth()])->sum('amount'),'services'=>Service::where('active',true)->count()];
  $upcoming=Appointment::with(['client','service','staff'])->where('appointment_date','>=',today())->whereNotIn('status',['cancelled','completed'])->when($u->role==='stylist',fn($x)=>$x->where('staff_id',$u->staff?->id ?: 0))->orderBy('appointment_date')->orderBy('start_time')->limit(8)->get();
  $popular=Service::withCount(['appointments'=>fn($q)=>$q->where('status','completed')])->orderByDesc('appointments_count')->limit(5)->get();
  return view('dashboard',compact('stats','todayAppointments','upcoming','popular'));
 }
}
