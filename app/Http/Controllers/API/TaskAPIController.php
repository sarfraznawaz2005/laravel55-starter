<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Task\Models\Task;

class TaskAPIController extends Controller
{
    private $pagesCount = 5;

    /**
     * Display a listing of the resource.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function index(Task $task): JsonResponse
    {
        return $this->getData($task);
    }

    /**
     * Store a newly created resource in storage.
     * @param Task $task
     * @return JsonResponse|\Illuminate\Support\MessageBag
     */
    public function store(Task $task)
    {
        $task->disableLoggingPlayer();

        $task->description = request()->description;
        $task->user_id = '1';
        $task->created_by = '1';
        $task->updated_by = '1';

        if (! $task->save()) {
            return $task->getErrors();
        }

        return $this->getData($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Task $task
     * @return mixed
     */
    protected function getData(Task $task) {
        return response()->json($task->latest()->paginate($this->pagesCount));
    }
}
