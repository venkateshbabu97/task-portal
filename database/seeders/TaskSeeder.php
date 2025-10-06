<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $requester = User::where('email', 'requester@example.com')->first();
        $contributor = User::where('email', 'contributor@example.com')->first();

        Task::create([
            'title' => 'Setup Project Repo',
            'description' => 'Initialize Laravel project and Git repo for task portal.',
            'status' => 'OPEN',
            'requester_id' => $requester->id,
            'assignee_id' => $contributor->id,
        ]);

        Task::create([
            'title' => 'Design Database Schema',
            'description' => 'Plan the models, relationships, and migrations for portal.',
            'status' => 'IN_PROGRESS',
            'requester_id' => $requester->id,
            'assignee_id' => $contributor->id,
        ]);
    }
}
