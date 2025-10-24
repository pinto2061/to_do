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
        /* $validatedData = $request->validated([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'finish_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',            
        ]); */

        // Crea la nueva tarea con los datos ya validados
        $task = Task::create($request->validated());

        // Devuelve una respuesta JSON exitosa
        return response()->json([
            'message' => 'Tarea creada exitosamente.',
            'data' => $task
        ], 201); // 201 significa "Created"
    }

    public function show(Task $task)
    {
        //
        $task = Task::find($task->id);
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada.'], 404);
        }
        return $task;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        //
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada.'], 404);
        }
        $task->update($request->validated());
        return response()->json([
            'message' => 'Tarea actualizada exitosamente.',
            'data' => $task
        ], 200); // 200: OK
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada.'], 404);
        }
        $task->destroy($id);
        return response()->json([
            'message' => 'Tarea eliminada exitosamente.',
        ], 200); // 200: OK
    }
}
