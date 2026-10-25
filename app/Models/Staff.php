<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Staff extends Model { use HasFactory; protected $fillable=['user_id','full_name','phone','email','specialty','commission_percent','active','notes']; protected $casts=['commission_percent'=>'decimal:2','active'=>'boolean']; public function user(){return $this->belongsTo(User::class);} public function services(){return $this->belongsToMany(Service::class,'staff_services');} public function schedules(){return $this->hasMany(StaffSchedule::class);} public function appointments(){return $this->hasMany(Appointment::class);} }
