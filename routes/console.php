<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('garage62:hello', function (): void {
    $this->info('Garage 62 Laravel app is ready.');
});
