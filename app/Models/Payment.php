<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Payment extends Model { use HasFactory; protected $fillable=['appointment_id','invoice_no','amount','method','status','transaction_ref','paid_at','created_by']; protected $casts=['amount'=>'decimal:2','paid_at'=>'datetime']; public function appointment(){return $this->belongsTo(Appointment::class);} public function creator(){return $this->belongsTo(User::class,'created_by');} }
