<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,DashboardController,ClientController,ServiceController,StaffController,ScheduleController,AppointmentController,SupplierController,InventoryController,PaymentController,ReportController,AdminController,PublicController,NotificationController};
Route::get('/',[PublicController::class,'home'])->name('home');
Route::get('/contact',[PublicController::class,'contact'])->name('contact');
Route::get('/feedback',[PublicController::class,'feedback'])->name('feedback.create');
Route::post('/feedback',[PublicController::class,'submitFeedback'])->name('feedback.store');
Route::middleware('guest')->group(function(){Route::get('/login',[AuthController::class,'showLogin'])->name('login');Route::post('/login',[AuthController::class,'login'])->name('login.attempt');});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::middleware('auth')->group(function(){
 Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
 Route::get('/appointments/calendar',[AppointmentController::class,'calendar'])->name('appointments.calendar');
 Route::resource('appointments',AppointmentController::class)->except('show');
 Route::middleware('role:admin,receptionist')->group(function(){ Route::resource('clients',ClientController::class); });
 Route::get('/notifications',[NotificationController::class,'index'])->name('notifications.index');Route::patch('/notifications/read-all',[NotificationController::class,'readAll'])->name('notifications.readAll');Route::patch('/notifications/{notification}/read',[NotificationController::class,'read'])->name('notifications.read');
 Route::middleware('role:admin,receptionist')->group(function(){Route::get('/payments',[PaymentController::class,'index'])->name('payments.index');Route::post('/payments',[PaymentController::class,'store'])->name('payments.store');Route::get('/payments/{payment}/invoice',[PaymentController::class,'invoice'])->name('payments.invoice');});
 Route::middleware('role:admin')->group(function(){
  Route::get('/services',[ServiceController::class,'index'])->name('services.index');Route::post('/services',[ServiceController::class,'store'])->name('services.store');Route::put('/services/{service}',[ServiceController::class,'update'])->name('services.update');Route::delete('/services/{service}',[ServiceController::class,'destroy'])->name('services.destroy');
  Route::get('/staff',[StaffController::class,'index'])->name('staff.index');Route::post('/staff',[StaffController::class,'store'])->name('staff.store');Route::put('/staff/{staff}',[StaffController::class,'update'])->name('staff.update');Route::delete('/staff/{staff}',[StaffController::class,'destroy'])->name('staff.destroy');
  Route::get('/staff-schedules',[ScheduleController::class,'index'])->name('staff.schedule');Route::post('/staff-schedules',[ScheduleController::class,'store'])->name('staff.schedule.store');Route::delete('/staff-schedules/{schedule}',[ScheduleController::class,'destroy'])->name('staff.schedule.destroy');
  Route::get('/inventory',[InventoryController::class,'index'])->name('inventory.index');Route::post('/inventory',[InventoryController::class,'store'])->name('inventory.store');Route::put('/inventory/{inventory}',[InventoryController::class,'update'])->name('inventory.update');Route::delete('/inventory/{inventory}',[InventoryController::class,'destroy'])->name('inventory.destroy');Route::post('/inventory/{inventory}/movement',[InventoryController::class,'movement'])->name('inventory.movement');
  Route::get('/suppliers',[SupplierController::class,'index'])->name('suppliers.index');Route::post('/suppliers',[SupplierController::class,'store'])->name('suppliers.store');Route::put('/suppliers/{supplier}',[SupplierController::class,'update'])->name('suppliers.update');Route::delete('/suppliers/{supplier}',[SupplierController::class,'destroy'])->name('suppliers.destroy');
  Route::get('/reports',[ReportController::class,'index'])->name('reports.index');Route::get('/reports/export',[ReportController::class,'csv'])->name('reports.csv');
  Route::get('/admin/users',[AdminController::class,'users'])->name('admin.users');Route::post('/admin/users',[AdminController::class,'storeUser'])->name('admin.users.store');Route::put('/admin/users/{user}',[AdminController::class,'updateUser'])->name('admin.users.update');
  Route::get('/admin/settings',[AdminController::class,'settings'])->name('admin.settings');Route::put('/admin/settings',[AdminController::class,'saveSettings'])->name('admin.settings.update');Route::get('/admin/feedback',[AdminController::class,'feedback'])->name('admin.feedback');
 });
});
