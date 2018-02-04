<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Task\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Task\Events\Subscribers\TaskSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        TaskSubscriber::class,
    ];

    public function boot()
    {
        parent::boot();
    }
}
