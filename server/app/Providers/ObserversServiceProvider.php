<?php

namespace App\Providers;

use App\Models\Address;
use App\Observers\AddressObserver;
use Illuminate\Support\ServiceProvider;

class ObserversServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Address::observe(AddressObserver::class);
    }
}