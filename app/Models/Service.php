<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Service extends Model { use HasFactory; protected $fillable=['name','category','duration_minutes','price','active']; protected $casts=['price'=>'decimal:2','active'=>'boolean']; public function staff(){return $this->belongsToMany(Staff::class,'staff_services');} public function appointments(){return $this->hasMany(Appointment::class);} }
