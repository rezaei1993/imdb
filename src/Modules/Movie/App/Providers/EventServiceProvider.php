<?php

namespace Modules\Movie\App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Movie\App\Models\Movie;
use Modules\Movie\App\Observers\MovieObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    public function boot()
    {
        Movie::observe(MovieObserver::class);
    }
}
