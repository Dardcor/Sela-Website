<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $schemaPath = base_path('db.sql');

        if (! is_file($schemaPath)) {
            throw new RuntimeException('db.sql not found at project root.');
        }

        $this->dropStatementIfRelationExists('public.subtask_progress', 'DROP TRIGGER IF EXISTS tr_notify_subtask_assigned ON public.subtask_progress');
        $this->dropStatementIfRelationExists('public.tasks', 'DROP TRIGGER IF EXISTS tr_notify_task_status_changed ON public.tasks');
        $this->dropStatementIfRelationExists('public.group_members', 'DROP TRIGGER IF EXISTS tr_notify_group_joined ON public.group_members');
        $this->dropStatementIfRelationExists('public.tasks', 'DROP TRIGGER IF EXISTS tr_notify_task_created ON public.tasks');
        $this->dropStatementIfRelationExists('auth.users', 'DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users');

        DB::unprepared(<<<'SQL'
            CREATE EXTENSION IF NOT EXISTS pgcrypto;

            DROP FUNCTION IF EXISTS public.notify_subtask_assigned() CASCADE;
            DROP FUNCTION IF EXISTS public.notify_task_status_changed() CASCADE;
            DROP FUNCTION IF EXISTS public.notify_group_joined() CASCADE;
            DROP FUNCTION IF EXISTS public.notify_task_created() CASCADE;
            DROP FUNCTION IF EXISTS public.handle_new_user() CASCADE;
            DROP FUNCTION IF EXISTS public.find_group_by_invite_code(text) CASCADE;
            DROP FUNCTION IF EXISTS public.is_group_member(uuid, uuid) CASCADE;

            DROP TABLE IF EXISTS public.notifications CASCADE;
            DROP TABLE IF EXISTS public.profile_abilities CASCADE;
            DROP TABLE IF EXISTS public.task_files CASCADE;
            DROP TABLE IF EXISTS public.task_links CASCADE;
            DROP TABLE IF EXISTS public.subtask_progress CASCADE;
            DROP TABLE IF EXISTS public.subtasks CASCADE;
            DROP TABLE IF EXISTS public.tasks CASCADE;
            DROP TABLE IF EXISTS public.group_members CASCADE;
            DROP TABLE IF EXISTS public.groups CASCADE;
            DROP TABLE IF EXISTS public.classes CASCADE;
            DROP TABLE IF EXISTS public.courses CASCADE;
            DROP TABLE IF EXISTS public.profiles CASCADE;

            DROP TABLE IF EXISTS public.support_files CASCADE;
            DROP TABLE IF EXISTS public.user_sessions CASCADE;
            DROP TABLE IF EXISTS public.sub_task_assignments CASCADE;
            DROP TABLE IF EXISTS public.sub_tasks CASCADE;
            DROP TABLE IF EXISTS public.password_resets CASCADE;
            DROP TABLE IF EXISTS public.user_abilities CASCADE;
            DROP TABLE IF EXISTS public.task_generations CASCADE;
            DROP TABLE IF EXISTS public.abilities CASCADE;
            DROP TABLE IF EXISTS public.user_ethol_sessions CASCADE;
            DROP TABLE IF EXISTS public.users CASCADE;
            DROP TABLE IF EXISTS public.personal_access_tokens CASCADE;
            DROP TABLE IF EXISTS public.sessions CASCADE;
            DROP TABLE IF EXISTS public.cache_locks CASCADE;
            DROP TABLE IF EXISTS public.cache CASCADE;
            DROP TABLE IF EXISTS public.job_batches CASCADE;
            DROP TABLE IF EXISTS public.failed_jobs CASCADE;
            DROP TABLE IF EXISTS public.jobs CASCADE;
        SQL);

        DB::unprepared(file_get_contents($schemaPath));
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $this->dropStatementIfRelationExists('public.subtask_progress', 'DROP TRIGGER IF EXISTS tr_notify_subtask_assigned ON public.subtask_progress');
        $this->dropStatementIfRelationExists('public.tasks', 'DROP TRIGGER IF EXISTS tr_notify_task_status_changed ON public.tasks');
        $this->dropStatementIfRelationExists('public.group_members', 'DROP TRIGGER IF EXISTS tr_notify_group_joined ON public.group_members');
        $this->dropStatementIfRelationExists('public.tasks', 'DROP TRIGGER IF EXISTS tr_notify_task_created ON public.tasks');
        $this->dropStatementIfRelationExists('auth.users', 'DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users');
        $this->dropStatementIfRelationExists('storage.objects', 'DROP POLICY IF EXISTS "Authenticated users can upload task files" ON storage.objects');
        $this->dropStatementIfRelationExists('storage.objects', 'DROP POLICY IF EXISTS "Task file owners can view their files" ON storage.objects');
        $this->dropStatementIfRelationExists('storage.objects', 'DROP POLICY IF EXISTS "Task file owners can delete their files" ON storage.objects');
        $this->dropStatementIfRelationExists('storage.objects', 'DROP POLICY IF EXISTS "Public Access" ON storage.objects');
        $this->dropStatementIfRelationExists('storage.objects', 'DROP POLICY IF EXISTS "Users can upload their own avatar" ON storage.objects');
        $this->dropStatementIfRelationExists('storage.objects', 'DROP POLICY IF EXISTS "Users can update their own avatar" ON storage.objects');
        $this->dropStatementIfRelationExists('storage.objects', 'DROP POLICY IF EXISTS "Users can delete their own avatar" ON storage.objects');
        $this->runStatementIfRelationExists('storage.buckets', "DELETE FROM storage.buckets WHERE id IN ('task-files', 'profiles')");

        DB::unprepared(<<<'SQL'
            DROP FUNCTION IF EXISTS public.notify_subtask_assigned() CASCADE;
            DROP FUNCTION IF EXISTS public.notify_task_status_changed() CASCADE;
            DROP FUNCTION IF EXISTS public.notify_group_joined() CASCADE;
            DROP FUNCTION IF EXISTS public.notify_task_created() CASCADE;
            DROP FUNCTION IF EXISTS public.handle_new_user() CASCADE;
            DROP FUNCTION IF EXISTS public.find_group_by_invite_code(text) CASCADE;
            DROP FUNCTION IF EXISTS public.is_group_member(uuid, uuid) CASCADE;

            DROP TABLE IF EXISTS public.notifications CASCADE;
            DROP TABLE IF EXISTS public.profile_abilities CASCADE;
            DROP TABLE IF EXISTS public.task_files CASCADE;
            DROP TABLE IF EXISTS public.task_links CASCADE;
            DROP TABLE IF EXISTS public.subtask_progress CASCADE;
            DROP TABLE IF EXISTS public.subtasks CASCADE;
            DROP TABLE IF EXISTS public.tasks CASCADE;
            DROP TABLE IF EXISTS public.group_members CASCADE;
            DROP TABLE IF EXISTS public.groups CASCADE;
            DROP TABLE IF EXISTS public.classes CASCADE;
            DROP TABLE IF EXISTS public.courses CASCADE;
            DROP TABLE IF EXISTS public.profiles CASCADE;
            DROP TABLE IF EXISTS public.personal_access_tokens CASCADE;
            DROP TABLE IF EXISTS public.sessions CASCADE;
            DROP TABLE IF EXISTS public.cache_locks CASCADE;
            DROP TABLE IF EXISTS public.cache CASCADE;
            DROP TABLE IF EXISTS public.job_batches CASCADE;
            DROP TABLE IF EXISTS public.failed_jobs CASCADE;
            DROP TABLE IF EXISTS public.jobs CASCADE;
        SQL);
    }

    private function dropStatementIfRelationExists(string $relation, string $statement): void
    {
        $this->runStatementIfRelationExists($relation, $statement);
    }

    private function runStatementIfRelationExists(string $relation, string $statement): void
    {
        $pdo = DB::getPdo();
        $quotedRelation = $pdo->quote($relation);
        $quotedStatement = $pdo->quote($statement);

        DB::unprepared(<<<SQL
            DO $$
            BEGIN
                IF to_regclass({$quotedRelation}) IS NOT NULL THEN
                    EXECUTE {$quotedStatement};
                END IF;
            END
            $$;
        SQL);
    }
};
