<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskTimerRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Отобразить список задач
     */
    public function index()
    {
        //
    }

    /**
     * Показать форму создания задачи
     */
    public function create(string $projectId)
    {
        return $this->edit(new Task, $projectId);
    }

    /**
     * Сохранить новую задачу
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            ...$request->all(),
            'user_id' => auth()->user()->id,
        ]);

        return Redirect::route('projects.tasks', ['project' => $task->project_id])->with('success', 'Task created.');
    }

    /**
     * Показать задачу
     */
    public function show(Task $task)
    {
        return Inertia::render('Task/Edit', [
            'task' => new TaskResource($task),
            'project' => new ProjectResource($task->project),
            'readonly' => true,
        ]);
    }

    /**
     * Показать форму редактирования задачи
     */
    public function edit(Task $task, ?string $projectId = null)
    {
        $project = $task->project ?: Project::find($projectId);

        return Inertia::render('Task/Edit', [
            'task' => new TaskResource($task),
            'project' => new ProjectResource($project),
            'users' => User::paginate(5)->items(),
        ]);
    }

    /**
     * Обновить задачу
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $updateData = $request->all();
        if (isset($updateData['assignee'])) {
            $updateData['assignee_id'] = $updateData['assignee']['id'];
        }
        $task->update($updateData);

        return Redirect::route('projects.tasks', ['project' => $task->project_id])->with('success', 'Task created.');
    }

    /**
     * Обновить таймер
     */
    public function updateTimer(UpdateTaskTimerRequest $request, Task $task)
    {
        $task->update($request->all());
    }

    /**
     * Удалить задачу
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return Redirect::back()->with('success', 'Task created.');
    }

    /**
     * Отобразить список задач для проекта
     */
    public function getByProject(string $projectId)
    {
        $project = Project::find($projectId);

        $taskList = Task::where('project_id', $project->id)
            ->orderBy('id', 'DESC')
            ->get();

        return Inertia::render('Task/List', [
            'project' => $project,
            'tasks' => TaskResource::collection($taskList),
        ]);
    }
}
