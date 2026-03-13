<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |----------------------------------
        | USERS
        |----------------------------------
        */

        for ($i = 1; $i <= 20; $i++) {

            DB::table('users')->insert([
                'username' => 'User ' . $i,
                'email' => 'user' . $i . '@mail.com',
                'password' => bcrypt('password'),
                'class' => 'Class ' . rand(1, 3),
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $userIds = DB::table('users')->pluck('id');


        /*
        |----------------------------------
        | ABILITIES
        |----------------------------------
        */

        for ($i = 1; $i <= 20; $i++) {

            DB::table('abilities')->insert([
                'name' => 'Skill ' . $i
            ]);
        }

        $abilityIds = DB::table('abilities')->pluck('id');


        /*
        |----------------------------------
        | GROUPS
        |----------------------------------
        */

        for ($i = 1; $i <= 20; $i++) {

            DB::table('groups')->insert([
                'name' => 'Group ' . $i,
                'course' => 'Course ' . rand(1, 5),
                'max_member' => rand(3, 6),
                'invitation_code' => strtoupper(Str::random(6)),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $groupIds = DB::table('groups')->pluck('id');


        /*
/*
|----------------------------------
| GROUP MEMBERS
|----------------------------------
*/

        foreach ($groupIds as $groupId) {

            // pilih 4 user unik
            $members = $userIds->random(4)->unique();

            $i = 0;

            foreach ($members as $userId) {

                DB::table('group_members')->insert([
                    'user_id' => $userId,
                    'group_id' => $groupId,
                    'role' => $i == 0 ? 'leader' : 'member',
                    'joined_at' => now()
                ]);

                $i++;
            }
        }


        /*
        |----------------------------------
        | TASKS
        |----------------------------------
        */

        for ($i = 1; $i <= 20; $i++) {

            DB::table('tasks')->insert([
                'title' => 'Task ' . $i,
                'description' => 'Description task ' . $i,
                'deadline' => Carbon::now()->addDays(rand(3, 10)),
                'group_id' => $groupIds->random(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $taskIds = DB::table('tasks')->pluck('id');


        /*
        |----------------------------------
        | SUB TASKS
        |----------------------------------
        */

        $status = ['pending', 'in_progress', 'done'];

        foreach ($taskIds as $taskId) {

            for ($i = 0; $i < 2; $i++) {

                DB::table('sub_tasks')->insert([
                    'name' => 'Subtask ' . $taskId . '-' . $i,
                    'task_id' => $taskId,
                    'status' => $status[array_rand($status)],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $subtaskIds = DB::table('sub_tasks')->pluck('id');


        /*
        |----------------------------------
        | SUB TASK ASSIGNMENTS
        |----------------------------------
        */

        foreach ($subtaskIds as $subtaskId) {

            DB::table('sub_task_assignments')->insert([
                'sub_task_id' => $subtaskId,
                'user_id' => $userIds->random(),
                'role' => 'assignee',
                'status' => 'assigned',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }


        /*
        |----------------------------------
        | USER ABILITIES
        |----------------------------------
        */

        foreach ($userIds as $userId) {

            DB::table('user_abilities')->insert([
                'user_id' => $userId,
                'ability_id' => $abilityIds->random(),
                'level' => rand(1, 5)
            ]);
        }


        /*
        |----------------------------------
        | SUPPORT FILES
        |----------------------------------
        */

        foreach ($taskIds as $taskId) {

            DB::table('support_files')->insert([
                'file_name' => 'dummy.pdf',
                'file_path' => 'support_files/dummy.pdf',
                'task_id' => $taskId,
                'uploaded_by' => $userIds->random(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
