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

        DB::unprepared('CREATE EXTENSION IF NOT EXISTS pgcrypto;');

        DB::unprepared(<<<'SQL'
            DROP TABLE IF EXISTS public.support_files CASCADE;
            DROP TABLE IF EXISTS public.user_sessions CASCADE;
            DROP TABLE IF EXISTS public.sub_task_assignments CASCADE;
            DROP TABLE IF EXISTS public.sub_tasks CASCADE;
            DROP TABLE IF EXISTS public.password_resets CASCADE;
            DROP TABLE IF EXISTS public.user_abilities CASCADE;
            DROP TABLE IF EXISTS public.task_generations CASCADE;
            DROP TABLE IF EXISTS public.abilities CASCADE;
        SQL);

        // CREATE LARAVEL INFRASTRUCTURE FIRST SO DB.SQL CAN REFERENCE IT IF NEEDED
        DB::unprepared(<<<'SQL'
            CREATE TABLE IF NOT EXISTS public.auth_users (
                id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
                username varchar(255) NOT NULL,
                email varchar(255) NOT NULL UNIQUE,
                password varchar(255) NOT NULL,
                class varchar(255),
                role varchar(255),
                remember_token varchar(100),
                created_at timestamp(0) without time zone,
                updated_at timestamp(0) without time zone
            );
            
            -- Keep users table mapped for Laravel conventions
            CREATE OR REPLACE VIEW public.users AS SELECT * FROM public.auth_users;
        SQL);

        $schemaContent = file_get_contents($schemaPath);
        $schemaContent = str_replace('auth.users', 'public.auth_users', $schemaContent);
        $schemaContent = str_replace('public.users', 'public.auth_users', $schemaContent);
        DB::unprepared($schemaContent);
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::unprepared(<<<'SQL'
            DROP TABLE IF EXISTS public.user_ethol_sessions CASCADE;
            DROP TABLE IF EXISTS public.personal_access_tokens CASCADE;
            DROP TABLE IF EXISTS public.users CASCADE;
        SQL);
    }
};