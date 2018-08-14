<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\User\Events\Subscribers\UserSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        UserSubscriber::class,
    ];

    public function boot()
    {
        parent::boot();
    }
}
