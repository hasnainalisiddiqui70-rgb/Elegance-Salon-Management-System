<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InventoryItem extends Model { use HasFactory; protected $fillable=['name','sku','category','quantity','reorder_level','cost_price','sale_price','supplier_id']; protected $casts=['cost_price'=>'decimal:2','sale_price'=>'decimal:2']; public function supplier(){return $this->belongsTo(Supplier::class);} public function movements(){return $this->hasMany(InventoryMovement::class);} public function getIsLowStockAttribute():bool{return $this->quantity <= $this->reorder_level;} }
