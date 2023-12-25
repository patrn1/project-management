<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Отобразить список проектов
     */
    public function index()
    {
        $projects = Project::orderBy('id', 'DESC')->get();

        return Inertia::render('Project/List', [
            'projects' => ProjectResource::collection($projects),
        ]);
    }

    /**
     * Показать форму создания проекта
     */
    public function create()
    {
        return $this->edit(new Project);
    }

    /**
     * Сохранить новый проект
     */
    public function store(StoreProjectRequest $request)
    {
        Project::create([
            ...$request->all(),
            'user_id' => auth()->user()->id,
        ]);

        return Redirect::route('projects.index')->with('success', 'Организация создана');
    }

    /**
     * Показать проект
     */
    public function show(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => new ProjectResource($project),
            'readonly' => true,
        ]);
    }

    /**
     * Показать форму редактирования проекта
     */
    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => new ProjectResource($project),
        ]);
    }

    /**
     * Обновить проект
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $updateData = $request->all();
        $project->update($updateData);

        return Redirect::route('projects.index')->with('success', 'Проект обновлен.');
    }

    /**
     * Удалить проект
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return Redirect::back()->with('success', 'Организация удалена');
    }
}
