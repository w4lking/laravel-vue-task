<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;


use Carbon\Carbon; 

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'completedVsPendingTaskChart' => $this->getCompletedVsPendingTaskChart(),
            'pendingTasksToday' => Task::query()
                ->where('is_completed', false)
                ->whereDate('due_date', now())
                ->count(),
            'tasksCreatedByDay' => $this->getTasksCreatedByDay(),
        ]);
    }

    private function getCompletedVsPendingTaskChart(): array
    {
        return [
            [
                'name' => 'Concluídas', // Ajuste o nome se quiser em português
                'total' => Task::query()->where('is_completed', true)->count(),
            ],
            [
                'name' => 'Em Andamento', // Ajuste o nome se quiser em português
                'total' => Task::query()->where('is_completed', false)->count(),
            ],
        ];
    }

    private function getTasksCreatedByDay(): array
    {
        // Começa na segunda-feira da semana atual
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY); // Use Carbon::MONDAY se quiser segunda como início da semana

        // Busca todas as tarefas criadas nesta semana e agrupa por dia
        $tasksByDay = Task::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startOfWeek, $startOfWeek->copy()->addDays(6)->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->date)->format('D'); // Usa o formato 'D' (ex: Mon, Tue)
            });

        // Mapeia para garantir que todos os 7 dias da semana estejam presentes (mesmo que com 0 tarefas)
        return collect(range(0, 6))
            ->map(function ($day) use ($startOfWeek, $tasksByDay) {
                $date = $startOfWeek->copy()->addDays($day);
                $dayName = $date->format('D');
                $count = $tasksByDay->get($dayName, (object)['count' => 0])->count; // Pega a contagem ou 0

                return [
                    'name' => $dayName, // Nome do dia (ex: Mon, Tue)
                    'TotalTasks' => $count // Mudei a chave para 'TotalTasks' (sem espaço)
                ];
            })
            ->toArray();
    }
}