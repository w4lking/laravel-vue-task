<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TaskCategory;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => Task::query()
                ->with(['media', 'taskCategories'])
                ->when($request->has('categories'), function ($query) use ($request) {
                    $query->whereHas('taskCategories', function ($query) use ($request) {
                        $query->whereIn('id', $request->query('categories'));
                    });
                })
                ->paginate(20),
            'categories' => TaskCategory::whereHas('tasks')->withCount('tasks')->get(),
            'selectedCategories' => $request->query('categories'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Tasks/Create', [
            'categories' => TaskCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
   // Em TaskController.php - store()
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->safe(['name', 'due_date']) + ['is_completed' => false]);

        if($request->hasFile('media')){
            $task->addMedia($request->file('media'))->toMediaCollection();
        }

        if($request->has('categories')){
            // CORREÇÃO: Chamar sync no método do relacionamento
            // Usar $request->validated('categories', []) também é uma boa prática para fornecer
            // um array vazio como padrão se 'categories' não estiver presente ou for opcional.
            $task->taskCategories()->sync($request->validated('categories', []));
        }

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $task->load(['media', 'taskCategories']);
        $task->append('mediaFile');

        return Inertia::render('Tasks/Edit', [
            'task' => $task,
            'categories' => TaskCategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        if($request->hasFile('media')){
            $task->getFirstMedia()?->delete();
            $task->addMedia($request->file('media'))->toMediaCollection();
        }

        $task->taskCategories()->sync($request->validated('categories', []));

        return redirect()->route('tasks.index');
    }

    
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
