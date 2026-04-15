<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $tasks = [
            ['Project kickoff meeting', 'Schedule and complete initial project kickoff.', 'high', 'pending', 0, 2],
            ['Prepare task board', 'Create backlog and initial sprint tasks.', 'medium', 'in_progress', 0, 3],
            ['Write project documentation', 'Document setup, structure, and workflow.', 'low', 'completed', -3, -1],
            ['Design task dashboard', 'Create a clean UI for task tracking.', 'medium', 'pending', 1, 4],
            ['Set up authentication', 'Configure login and access flow.', 'high', 'in_progress', 0, 5],
            ['Build task CRUD API', 'Implement full task API endpoints.', 'high', 'pending', 1, 6],
            ['Create search feature', 'Add task search in list view.', 'medium', 'completed', -2, 1],
            ['Add pagination', 'Paginate task listing results.', 'medium', 'pending', 2, 7],
            ['Validate form inputs', 'Add frontend and backend validation.', 'high', 'in_progress', 0, 3],
            ['Test task creation', 'Check create flow and API response.', 'low', 'pending', 1, 2],
            ['Fix reload routing', 'Ensure SPA routes work on refresh.', 'medium', 'completed', -1, 0],
            ['Refine task detail page', 'Display all task fields clearly.', 'low', 'pending', 2, 5],
            ['Improve task edit form', 'Add proper fields and update flow.', 'medium', 'in_progress', 0, 4],
            ['Seed demo records', 'Prepare sample tasks for testing.', 'low', 'completed', -4, -2],
            ['Review validation rules', 'Check date and field constraints.', 'medium', 'pending', 1, 3],
            ['Format API responses', 'Standardize JSON response structure.', 'low', 'completed', -2, 0],
            ['Connect frontend API', 'Hook Vue pages to task endpoints.', 'high', 'in_progress', 0, 4],
            ['Handle empty states', 'Show friendly message when no tasks exist.', 'low', 'pending', 1, 2],
            ['Add delete confirmation', 'Prevent accidental task deletion.', 'medium', 'pending', 2, 6],
            ['Final UI polish', 'Tune spacing and alignment in task screens.', 'low', 'completed', -1, 1],
        ];

        $rows = [];

        foreach ($tasks as [$title, $description, $priority, $status, $startOffset, $endOffset]) {
            $rows[] = [
                'title' => $title,
                'description' => $description,
                'assigned_to' => null,
                'priority' => $priority,
                'status' => $status,
                'start_date' => $now->copy()->addDays($startOffset),
                'end_date' => $now->copy()->addDays($endOffset),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tasks')->insert($rows);
    }
}