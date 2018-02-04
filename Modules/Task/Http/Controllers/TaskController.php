<?php

namespace Modules\Task\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController;

class TaskController extends CoreController
{
    // show listing
    public function index(TasksDataTable $dataTable)
    {
        title('Task List');

        return $dataTable->render('task::pages.task.index');
    }

    // create
    public function store(Task $task)
    {
        return $this->createRecord($task);
    }

    // update task "complete" status
    public function complete(Task $task)
    {
        $task->completed = $task->completed === 'No' ? 1 : 0;

        return $this->updateRecord($task);
    }

    // edit page
    public function edit(Task $task)
    {
        title('Edit Task');

        // show only if logged user is owner of this record
        $this->isOwner($task);

        return view('task::pages.task.edit', compact('task'));
    }

    // update
    public function update(Task $task)
    {
        return $this->updateRecord($task);
    }

    // delete
    public function destroy(Task $task)
    {
        return $this->deleteRecord($task);
    }
}
