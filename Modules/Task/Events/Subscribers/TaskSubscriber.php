<?php

namespace Modules\Task\Events\Subscribers;

use Log;
use Modules\Task\Models\Task;

class TaskSubscriber
{
    public function onCreated($model)
    {
        Log::info('Task #' . $model->id . ' was created.');
    }

    public function onUpdated($model)
    {
        Log::info('Task #' . $model->id . ' was updated.');
    }

    public function onDeleted($model)
    {
        Log::info('Task #' . $model->id . ' was deleted.');
    }

    public function subscribe($events)
    {
        $events->listen('eloquent.created: ' . Task::class, TaskSubscriber::class . '@onCreated');
        $events->listen('eloquent.updated: ' . Task::class, TaskSubscriber::class . '@onUpdated');
        $events->listen('eloquent.deleted: ' . Task::class, TaskSubscriber::class . '@onDeleted');
    }
}
