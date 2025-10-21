<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request; 

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Task::all();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // 1. La validación ya ocurrió automáticamente gracias a StoreTaskRequest.
        // 2. Podemos acceder a los datos validados de forma segura con $request->validated().
        $validatedData = $request->validated();

        // Crea la nueva tarea con los datos ya validados
        $task = Task::create($validatedData);

        // Devuelve una respuesta JSON exitosa
        return response()->json([
            'message' => 'Tarea creada exitosamente.',
            'data' => $task
        ], 201); // 201 significa "Created"
    }

    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
