<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InventoryMovement extends Model { use HasFactory; protected $fillable=['item_id','movement_type','quantity','note','created_by']; public function item(){return $this->belongsTo(InventoryItem::class,'item_id');} public function creator(){return $this->belongsTo(User::class,'created_by');} }
