<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User,Client,Service,Staff,StaffSchedule,Supplier,InventoryItem,Setting,Appointment,Payment,Notification};
use Carbon\Carbon;
class DatabaseSeeder extends Seeder {
 public function run():void {
  $admin=User::updateOrCreate(['email'=>'admin@elegance.local'],['name'=>'Ayesha Admin','password'=>Hash::make('Admin@123'),'role'=>'admin','active'=>true]);
  $reception=User::updateOrCreate(['email'=>'reception@elegance.local'],['name'=>'Sara Reception','password'=>Hash::make('Reception@123'),'role'=>'receptionist','active'=>true]);
  $stylistUser=User::updateOrCreate(['email'=>'stylist@elegance.local'],['name'=>'Noor Stylist','password'=>Hash::make('Stylist@123'),'role'=>'stylist','active'=>true]);
  $services=[['Hair Cut & Styling','Hair',60,2500],['Hair Color','Hair',120,6500],['Manicure','Nails',45,1800],['Pedicure','Nails',60,2200],['Classic Facial','Skin',75,3500],['Party Makeup','Makeup',90,8000]];
  foreach($services as $s) Service::updateOrCreate(['name'=>$s[0]],['category'=>$s[1],'duration_minutes'=>$s[2],'price'=>$s[3],'active'=>true]);
  $staff=Staff::updateOrCreate(['user_id'=>$stylistUser->id],['full_name'=>'Noor Fatima','phone'=>'0300-1112233','email'=>'stylist@elegance.local','specialty'=>'Hair & Makeup','commission_percent'=>20,'active'=>true]);
  $staff->services()->sync(Service::whereIn('category',['Hair','Makeup'])->pluck('id'));
  foreach(range(1,6) as $day) StaffSchedule::updateOrCreate(['staff_id'=>$staff->id,'day_of_week'=>$day],['start_time'=>'10:00','end_time'=>'20:00']);
  $supplier=Supplier::updateOrCreate(['name'=>'Beauty Supply Co.'],['contact_person'=>'Sales Desk','phone'=>'0300-0000000','email'=>'sales@example.com','address'=>'Karachi']);
  foreach([['Professional Shampoo','SHA-001','Hair Care',15,5,950,1400],['Hair Color Tube','COL-001','Hair Color',8,5,1200,1800],['Nail Polish Set','NAI-001','Nails',4,5,2500,3500]] as $i) InventoryItem::updateOrCreate(['sku'=>$i[1]],['name'=>$i[0],'category'=>$i[2],'quantity'=>$i[3],'reorder_level'=>$i[4],'cost_price'=>$i[5],'sale_price'=>$i[6],'supplier_id'=>$supplier->id]);
  $client=Client::updateOrCreate(['phone'=>'0300-5558899'],['full_name'=>'Hira Khan','email'=>'hira@example.com','preferences'=>'Prefers gentle products','notes'=>'Demo client']);
  $service=Service::first();
  Appointment::updateOrCreate(['client_id'=>$client->id,'appointment_date'=>now()->addDay()->toDateString(),'start_time'=>'12:00:00'],['service_id'=>$service->id,'staff_id'=>$staff->id,'end_time'=>'13:00:00','status'=>'confirmed','notes'=>'Demo appointment','created_by'=>$reception->id]);
  foreach(['salon_email'=>'hello@elegancesalon.local','salon_phone'=>'+92 300 1234567','salon_address'=>'Main Boulevard, Karachi, Pakistan','business_hours'=>'Mon–Sat: 10:00 AM – 8:00 PM','salon_name'=>'Elegance Salon'] as $k=>$v) Setting::updateOrCreate(['key'=>$k],['value'=>$v]);
  Notification::firstOrCreate(['user_id'=>$admin->id,'title'=>'Welcome to Elegance'],['message'=>'Your Laravel salon management dashboard is ready.','type'=>'success']);
 }
}
