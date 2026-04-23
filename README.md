# Sela-Website

Laravel 12 backend for the Sela project management platform. The current repo is configured around **Supabase PostgreSQL** and **Laravel Sanctum**.

> Status note: this repository still contains some legacy controller/service naming (`UserAbility`, `SubTask`, `SupportFile`, etc.), but the active PostgreSQL schema is imported from `db.sql` through `database/migrations/2026_04_07_150000_apply_supabase_schema_from_db_sql.php`.

**Production:** `https://dardcor.acalypha.my.id/api`

## Tech Stack

- **Framework:** Laravel 12
- **PHP:** `^8.2`
- **Auth:** Laravel Sanctum bearer tokens
- **Database:** PostgreSQL via Supabase
- **Frontend assets:** Vite
- **Deployment:** AWS EC2 + Nginx + PHP-FPM + Let's Encrypt
- **ETHOL Integration:** PENS academic portal login flow

## Project Structure

- `routes/api.php` — active API routes
- `app/Http/Controllers/Api` — API controllers
- `app/Models` — current Eloquent models
- `db.sql` — source schema imported for PostgreSQL/Supabase
- `database/migrations/2026_04_07_150000_apply_supabase_schema_from_db_sql.php` — applies `db.sql`
- `deploy/` — deployment scripts and Nginx config

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Set your database config in `.env`.

### Supabase / PostgreSQL example

Use either discrete variables:

```env
DB_CONNECTION=pgsql
DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.YOUR_PROJECT_REF
DB_PASSWORD=your-password
DB_SSLMODE=require
```

Or pooled connection URL:

```env
DB_CONNECTION=pgsql
DB_URL=postgresql://postgres.YOUR_PROJECT_REF:YOUR_PASSWORD@aws-1-ap-southeast-1.pooler.supabase.com:5432/postgres
DB_SSLMODE=require
```

Then run:

```bash
php artisan migrate
php artisan serve
```

### Frontend assets

This repo includes Vite assets. If you change frontend files, run:

```bash
npm install
npm run build
```

> `public/build/` may already be present in the repo, so asset build is not always required just to boot the backend.

## Authentication

Public routes:

- `POST /api/register`
- `POST /api/login`
- `POST /api/ethol/login`

All other API routes are protected by `auth:sanctum`.

Typical headers:

| Header | Value |
|---|---|
| `Accept` | `application/json` |
| `Authorization` | `Bearer {token}` |

## API Routes

This section reflects the current `routes/api.php` file.

### Auth

| Method | Endpoint |
|---|---|
| `POST` | `/api/register` |
| `POST` | `/api/login` |
| `POST` | `/api/logout` |
| `GET` | `/api/me` |

### Dashboard

| Method | Endpoint |
|---|---|
| `GET` | `/api/dashboard/{user_id}` |

### Users

| Method | Endpoint |
|---|---|
| `GET` | `/api/users` |
| `GET` | `/api/users/{id}` |
| `PUT` | `/api/users/{id}` |
| `DELETE` | `/api/users/{id}` |

### Abilities

| Method | Endpoint |
|---|---|
| `GET` | `/api/abilities` |
| `POST` | `/api/abilities` |
| `GET` | `/api/abilities/{ability}` |
| `PUT/PATCH` | `/api/abilities/{ability}` |
| `DELETE` | `/api/abilities/{ability}` |

### User Abilities

| Method | Endpoint |
|---|---|
| `GET` | `/api/users/{userId}/abilities` |
| `POST` | `/api/users/{userId}/abilities` |
| `PUT` | `/api/user-abilities/{id}` |
| `DELETE` | `/api/user-abilities/{id}` |

### Groups

| Method | Endpoint |
|---|---|
| `GET` | `/api/groups/user/{user_id}` |
| `GET` | `/api/groups/{group_id}` |
| `POST` | `/api/groups` |
| `POST` | `/api/groups/join` |

### Group Members

| Method | Endpoint |
|---|---|
| `GET` | `/api/groups/{groupId}/members` |
| `POST` | `/api/groups/{groupId}/members` |
| `PUT` | `/api/group-members/{id}` |
| `DELETE` | `/api/groups/{groupId}/members/{userId}` |

### Tasks

| Method | Endpoint |
|---|---|
| `GET` | `/api/tasks/user/{user_id}` |
| `GET` | `/api/tasks/{task_id}/detail/{user_id}` |
| `POST` | `/api/tasks` |

### Subtasks

| Method | Endpoint |
|---|---|
| `POST` | `/api/tasks/{task_id}/subtasks` |
| `PATCH` | `/api/subtasks/{subtask_id}/status` |
| `DELETE` | `/api/subtasks/{id}` |

### Subtask Assignments

| Method | Endpoint |
|---|---|
| `GET` | `/api/sub-tasks/{subTaskId}/assignments` |
| `POST` | `/api/sub-tasks/{subTaskId}/assignments` |
| `PUT` | `/api/sub-task-assignments/{id}` |
| `DELETE` | `/api/sub-task-assignments/{id}` |

### Support Files

| Method | Endpoint |
|---|---|
| `GET` | `/api/tasks/{taskId}/files` |
| `POST` | `/api/tasks/{taskId}/files` |
| `GET` | `/api/support-files/{id}` |
| `DELETE` | `/api/support-files/{id}` |

### Task Generations

| Method | Endpoint |
|---|---|
| `GET` | `/api/tasks/{taskId}/generations` |
| `POST` | `/api/tasks/{taskId}/generations` |
| `GET` | `/api/task-generations/{id}` |
| `DELETE` | `/api/task-generations/{id}` |

### ETHOL

| Method | Endpoint |
|---|---|
| `POST` | `/api/ethol/login` |
| `POST` | `/api/ethol/logout` |
| `GET` | `/api/ethol/schedule` |
| `GET` | `/api/ethol/homework` |
| `GET` | `/api/ethol/attendance` |
| `GET` | `/api/ethol/token` |

## Database Schema

For PostgreSQL/Supabase, the effective schema is the SQL file at the project root:

- `db.sql`

It is applied by:

- `database/migrations/2026_04_07_150000_apply_supabase_schema_from_db_sql.php`

### Main tables in `db.sql`

- `profiles`
- `courses`
- `classes`
- `groups`
- `group_members`
- `tasks`
- `subtasks`
- `subtask_progress`
- `task_links`
- `task_files`
- `profile_abilities`
- `notifications`

### Schema notes

- IDs are mostly UUIDs
- `profiles.id` references `auth.users`
- storage policies depend on Supabase `storage.objects` and `storage.buckets`
- several RLS policies depend on Supabase `auth.uid()`
- the migration imports trigger/function definitions from `db.sql`

## Current Models

The active Eloquent models currently present in `app/Models` are:

- `User`
- `Profile`
- `Course`
- `SchoolClass`
- `Group`
- `GroupMember`
- `Task`
- `Subtask`
- `SubtaskProgress`
- `TaskFile`
- `TaskLink`
- `ProfileAbility`
- `Notification`

## Known Repo Caveat

This repo is in a transition state:

- the **database schema** and **models** already point toward the Supabase/UUID structure
- some **route names**, **controller names**, and **service names** still reflect the older Laravel schema terminology

If documentation and implementation ever disagree, use these as the source of truth in order:

1. `routes/api.php`
2. `db.sql`
3. `database/migrations/2026_04_07_150000_apply_supabase_schema_from_db_sql.php`
4. `app/Models`

## Deployment

Deploy target: AWS EC2 + Nginx + PHP-FPM + Supabase PostgreSQL.

### Server bootstrap

```bash
ssh -i "your-key.pem" ubuntu@YOUR_EC2_IP
sudo git clone -b backend https://github.com/Dardcor/Sela-Website.git /var/www/sela-website
sudo bash /var/www/sela-website/deploy/setup-server.sh
```

### Environment

```bash
cd /var/www/sela-website
sudo cp .env.example .env
sudo nano .env
```

Minimum important settings:

```env
APP_URL=https://your-domain.example
DB_CONNECTION=pgsql
DB_HOST=...
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=...
DB_PASSWORD=...
DB_SSLMODE=require
```

### Deploy

```bash
sudo bash deploy/deploy.sh
sudo bash deploy/setup-ssl.sh
```

### What `deploy.sh` does

- validates `.env`
- pulls the `backend` branch
- runs Composer install
- runs migrations
- creates storage symlink
- clears/builds Laravel caches
- fixes permissions
- reloads Nginx and restarts PHP-FPM

## Troubleshooting

| Issue | Fix |
|---|---|
| 502 Bad Gateway | `sudo systemctl restart php8.2-fpm` |
| Wrong database selected | ensure `DB_CONNECTION=pgsql` is set |
| Supabase connection refused | verify host, username, password, SSL mode, and whether project is paused |
| Migration fails on Supabase objects | confirm `auth.users`, `storage.objects`, and `storage.buckets` exist in the target project |
| SSL expired | `sudo certbot renew` |

```bash
tail -f /var/www/sela-website/storage/logs/laravel.log
```
"# Sela-Website-Test" 
