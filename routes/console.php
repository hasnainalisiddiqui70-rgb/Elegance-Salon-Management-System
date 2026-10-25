<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('salon:hello', function () { $this->info('Elegance Salon is ready.'); });
