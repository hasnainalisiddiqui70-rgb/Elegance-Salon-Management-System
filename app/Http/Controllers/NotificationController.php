<?php
namespace App\Http\Controllers; use App\Models\Notification;
class NotificationController extends Controller { public function index(){return view('notifications.index',['notifications'=>auth()->user()->notifications()->latest()->paginate(20)]);} public function read(Notification $notification){abort_unless($notification->user_id===auth()->id(),403);$notification->update(['read_at'=>now()]);return back();} public function readAll(){auth()->user()->notifications()->whereNull('read_at')->update(['read_at'=>now()]);return back()->with('success','All notifications marked as read.');} }
