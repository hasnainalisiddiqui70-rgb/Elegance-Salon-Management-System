<?php
namespace App\Http\Controllers; use App\Models\{Payment,Appointment}; use Illuminate\Http\Request;
class PaymentController extends Controller {
 public function index(Request $r){$q=Payment::with(['appointment.client','appointment.service','creator']);if($r->status)$q->where('status',$r->status);return view('payments.index',['payments'=>$q->latest()->paginate(15)->withQueryString(),'appointments'=>Appointment::with(['client','service'])->whereIn('status',['confirmed','completed'])->orderByDesc('appointment_date')->limit(100)->get()]);}
 public function store(Request $r){$d=$r->validate(['appointment_id'=>'required|exists:appointments,id','amount'=>'required|numeric|min:0.01','method'=>'required|in:cash,card,bank,wallet','status'=>'required|in:paid,pending,refunded','transaction_ref'=>'nullable|string|max:100']);$d['invoice_no']='ELS-'.now()->format('Ymd').'-'.str_pad((string)((Payment::max('id')??0)+1),5,'0',STR_PAD_LEFT);$d['paid_at']=$d['status']==='paid'?now():null;$d['created_by']=$r->user()->id;$p=Payment::create($d);return redirect()->route('payments.invoice',$p)->with('success','Payment recorded.');}
 public function invoice(Payment $payment){$payment->load(['appointment.client','appointment.service','appointment.staff']);return view('payments.invoice',compact('payment'));}
}
