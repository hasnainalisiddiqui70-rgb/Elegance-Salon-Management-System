<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Appointment extends Model { use HasFactory; protected $fillable=['client_id','service_id','staff_id','appointment_date','start_time','end_time','status','notes','created_by']; protected $casts=['appointment_date'=>'date']; public function client(){return $this->belongsTo(Client::class);} public function service(){return $this->belongsTo(Service::class);} public function staff(){return $this->belongsTo(Staff::class);} public function creator(){return $this->belongsTo(User::class,'created_by');} public function payments(){return $this->hasMany(Payment::class);} }
