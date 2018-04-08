<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        return response()->json($this->getData($task), Response::HTTP_OK);
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

        // dummy values
        $task->user_id = '1';
        $task->created_by = '1';
        $task->updated_by = '1';

        if (!$task->save()) {
            return response()->json($task->getErrors()->all(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($task, Response::HTTP_CREATED);
    }

    /**
     * View specific resource
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $task = Task::find($id);

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     * @param $id
     * @return JsonResponse|\Illuminate\Support\MessageBag
     */
    public function update($id)
    {
        $task = Task::find($id);

        return $this->store($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task->delete()) {
            return response()->json([]);
        }
    }

    /**
     * @param Task $task
     * @return mixed
     */
    protected function getData(Task $task)
    {
        return $task->latest()->paginate($this->pagesCount);
    }
}
