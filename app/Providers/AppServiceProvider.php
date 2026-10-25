<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Notification;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {}
    public function boot(): void {
        View::composer('*', function ($view) {
            $settings = collect();
            $unreadNotifications = 0;
            try {
                $settings = Setting::query()->pluck('value','key');
                if (auth()->check()) $unreadNotifications = Notification::where('user_id', auth()->id())->whereNull('read_at')->count();
            } catch (\Throwable $e) {}
            $view->with(compact('settings','unreadNotifications'));
        });
    }
}
