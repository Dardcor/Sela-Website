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

        // Drop only legacy tables that are NOT part of the current schema (db.sql)
        // and are no longer used by the application.
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

        // Apply the idempotent Supabase schema.
        // db.sql uses CREATE TABLE IF NOT EXISTS, CREATE OR REPLACE FUNCTION,
        // DROP POLICY IF EXISTS + CREATE POLICY, etc., so it is safe to run
        // multiple times without destroying existing data.
        DB::unprepared(file_get_contents($schemaPath));

        // Ensure Laravel infrastructure tables exist.
        // These are required by the application (Sanctum, ETHOL sessions)
        // but are NOT managed by Supabase / db.sql.
        DB::unprepared(<<<'SQL'
            CREATE TABLE IF NOT EXISTS public.users (
                id bigserial PRIMARY KEY,
                username varchar(255) NOT NULL,
                email varchar(255) NOT NULL UNIQUE,
                password varchar(255) NOT NULL,
                class varchar(255),
                role varchar(255),
                remember_token varchar(100),
                created_at timestamp(0) without time zone,
                updated_at timestamp(0) without time zone
            );

            CREATE TABLE IF NOT EXISTS public.personal_access_tokens (
                id bigserial PRIMARY KEY,
                tokenable_type varchar(255) NOT NULL,
                tokenable_id bigint NOT NULL,
                name varchar(255) NOT NULL,
                token varchar(64) NOT NULL UNIQUE,
                abilities text,
                last_used_at timestamp(0) without time zone,
                expires_at timestamp(0) without time zone,
                created_at timestamp(0) without time zone,
                updated_at timestamp(0) without time zone
            );

            CREATE TABLE IF NOT EXISTS public.user_ethol_sessions (
                id bigserial PRIMARY KEY,
                user_id bigint NOT NULL,
                ethol_token text NOT NULL,
                ethol_cookies text,
                created_at timestamp(0) without time zone,
                updated_at timestamp(0) without time zone
            );
        SQL);
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        // Only drop Laravel infrastructure tables.
        // Supabase-managed tables (from db.sql) are intentionally NOT dropped
        // to prevent accidental data loss.
        DB::unprepared(<<<'SQL'
            DROP TABLE IF EXISTS public.user_ethol_sessions CASCADE;
            DROP TABLE IF EXISTS public.personal_access_tokens CASCADE;
            DROP TABLE IF EXISTS public.users CASCADE;
        SQL);
    }
};
