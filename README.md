# Sela-Website

Backend API for the Sela project management platform. Built with Laravel 12, Sanctum auth, and PostgreSQL (Supabase).

**Production:** `https://dardcor.acalypha.my.id/api`

## Tech Stack

- **Framework:** Laravel 12 (PHP 8.5)
- **Auth:** Laravel Sanctum (Bearer Token)
- **Database:** PostgreSQL via Supabase
- **Server:** AWS EC2 + Nginx + PHP-FPM + Let's Encrypt SSL
- **ETHOL Integration:** PENS CAS authentication for student login

## Getting Started

```bash
# Clone
cd Sela-Website

# Install
composer install

# Configure
cp .env.example .env
# Edit .env with your DB credentials
php artisan key:generate

# Migrate & serve
php artisan migrate
php artisan serve
```

## Authentication

All endpoints except `POST /api/register`, `POST /api/login`, and `POST /api/ethol/login` require a Bearer token.

**Headers (all requests):**
| Header | Value |
|--------|-------|
| `Accept` | `application/json` |
| `Authorization` | `Bearer {token}` |

For `POST`/`PUT` requests, add `Content-Type: application/json`.

**HTTP Status Codes:**
| Code | Description |
|------|-------------|
| `200` | OK |
| `201` | Created |
| `204` | No Content (deleted) |
| `401` | Unauthorized |
| `404` | Not Found |
| `422` | Validation Error |

---

## API Reference

### Auth

#### `POST /api/register`

**Auth:** Not Required

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| username | string | Yes | max:50 |
| email | string | Yes | email, max:100, unique |
| password | string | Yes | min:6 |
| class | string | No | max:100 |
| role | string | No | max:50 |

**Response:** `201`
```json
{
  "user": {
    "id": 1,
    "username": "johndoe",
    "email": "john@example.com",
    "class": "IF-2022",
    "role": "student",
    "created_at": "2024-03-05T00:00:00.000000Z",
    "updated_at": "2024-03-05T00:00:00.000000Z"
  },
  "token": "1|abcdef123456"
}
```

#### `POST /api/login`

**Auth:** Not Required

| Field | Type | Required |
|-------|------|----------|
| email | string | Yes |
| password | string | Yes |

**Response:** `200` — same shape as register.

#### `POST /api/logout`

**Auth:** Required

**Response:** `200`
```json
{ "message": "Logged out successfully." }
```

#### `GET /api/me`

**Auth:** Required

**Response:** `200` — user object.

---

### Users

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/users` | Yes | List all users |
| `GET` | `/api/users/{id}` | Yes | Get user by ID |
| `PUT` | `/api/users/{id}` | Yes | Update user |
| `DELETE` | `/api/users/{id}` | Yes | Delete user (`204`) |

**Update fields:** `username`, `email`, `password`, `class`, `role` (all optional).

---

### Abilities

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/abilities` | Yes | List all abilities |
| `POST` | `/api/abilities` | Yes | Create ability |
| `GET` | `/api/abilities/{ability}` | Yes | Get ability |
| `PUT` | `/api/abilities/{ability}` | Yes | Update ability |
| `DELETE` | `/api/abilities/{ability}` | Yes | Delete ability (`204`) |

**Body:** `{ "name": "Backend Development" }`

---

### User Abilities

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/users/{userId}/abilities` | Yes | List user's abilities |
| `POST` | `/api/users/{userId}/abilities` | Yes | Assign ability to user |
| `PUT` | `/api/user-abilities/{id}` | Yes | Update level |
| `DELETE` | `/api/user-abilities/{id}` | Yes | Remove ability (`204`) |

**Assign body:**
| Field | Type | Required |
|-------|------|----------|
| ability_id | integer | Yes |
| level | integer | No (default 0) |

---

### Groups

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/groups` | Yes | List all groups |
| `POST` | `/api/groups` | Yes | Create group |
| `GET` | `/api/groups/{group}` | Yes | Get group |
| `PUT` | `/api/groups/{group}` | Yes | Update group |
| `DELETE` | `/api/groups/{group}` | Yes | Delete group (`204`) |

**Create body:**
| Field | Type | Required |
|-------|------|----------|
| name | string | Yes |
| course | string | No |
| max_member | integer | No |
| invitation_code | string | No |

---

### Group Members

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/groups/{groupId}/members` | Yes | List members |
| `POST` | `/api/groups/{groupId}/members` | Yes | Add member |
| `PUT` | `/api/group-members/{id}` | Yes | Update role |
| `DELETE` | `/api/groups/{groupId}/members/{userId}` | Yes | Remove member (`204`) |

**Add body:** `{ "user_id": 2, "role": "member" }`

---

### Tasks

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/tasks` | Yes | List all tasks |
| `POST` | `/api/tasks` | Yes | Create task |
| `GET` | `/api/tasks/{task}` | Yes | Get task |
| `PUT` | `/api/tasks/{task}` | Yes | Update task |
| `DELETE` | `/api/tasks/{task}` | Yes | Delete task (`204`) |

**Create body:**
| Field | Type | Required |
|-------|------|----------|
| title | string | Yes |
| type | string | No |
| description | string | No |
| deadline | date | No |
| group_id | integer | Yes |

---

### Sub Tasks

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/tasks/{taskId}/sub-tasks` | Yes | List sub tasks |
| `POST` | `/api/tasks/{taskId}/sub-tasks` | Yes | Create sub task |
| `GET` | `/api/sub-tasks/{id}` | Yes | Get sub task |
| `PUT` | `/api/sub-tasks/{id}` | Yes | Update sub task |
| `DELETE` | `/api/sub-tasks/{id}` | Yes | Delete sub task (`204`) |

**Create body:**
| Field | Type | Required |
|-------|------|----------|
| name | string | Yes |
| description | string | No |
| required_ability_id | integer | No |
| generation_id | integer | No |
| status | string | No |

---

### Sub Task Assignments

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/sub-tasks/{subTaskId}/assignments` | Yes | List assignments |
| `POST` | `/api/sub-tasks/{subTaskId}/assignments` | Yes | Assign user |
| `PUT` | `/api/sub-task-assignments/{id}` | Yes | Update assignment |
| `DELETE` | `/api/sub-task-assignments/{id}` | Yes | Remove assignment (`204`) |

**Assign body:** `{ "user_id": 1, "role": "assignee", "status": "active" }`

---

### Support Files

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/tasks/{taskId}/files` | Yes | List files |
| `POST` | `/api/tasks/{taskId}/files` | Yes | Upload file (`multipart/form-data`) |
| `GET` | `/api/support-files/{id}` | Yes | Get file metadata |
| `DELETE` | `/api/support-files/{id}` | Yes | Delete file (`204`) |

**Upload:** `file` field, max 10MB.

---

### Task Generations (AI)

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/api/tasks/{taskId}/generations` | Yes | List generations |
| `POST` | `/api/tasks/{taskId}/generations` | Yes | Store generation |
| `GET` | `/api/task-generations/{id}` | Yes | Get generation |
| `DELETE` | `/api/task-generations/{id}` | Yes | Delete generation (`204`) |

**Create body:**
| Field | Type | Required |
|-------|------|----------|
| prompt | string | Yes |
| ai_response | string | No |
| model | string | No |
| version | integer | No |

---

### ETHOL (PENS CAS)

#### `POST /api/ethol/login`

**Auth:** Not Required — alternative login via PENS CAS. Auto-creates user account if needed. Returns Sanctum token.

| Field | Type | Required |
|-------|------|----------|
| email | string | Yes |
| password | string | Yes |

**Response:** `200`
```json
{
  "user": {
    "id": 1,
    "username": "Fahroldhi Sukirno",
    "email": "fahroldhisukirno@it.student.pens.ac.id",
    "class": null,
    "role": "student",
    "created_at": "2024-03-05T00:00:00.000000Z",
    "updated_at": "2024-03-05T00:00:00.000000Z"
  },
  "token": "1|abcdef123456"
}
```

#### Other ETHOL Endpoints (Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/ethol/logout` | Clear ETHOL session |
| `GET` | `/api/ethol/schedule` | Get course schedule |
| `GET` | `/api/ethol/homework` | Get homework list |
| `GET` | `/api/ethol/attendance` | Get attendance summary |
| `GET` | `/api/ethol/token` | Get stored ETHOL JWT |

---

## Database Schema

### `users`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| username | varchar(50) |
| email | varchar(100), unique |
| password | varchar(255) |
| class | varchar(100), nullable |
| role | varchar(50), nullable |

### `abilities`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| name | varchar(50) |

### `user_abilities`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| user_id | FK → users |
| ability_id | FK → abilities |
| level | int, default 0 |

### `groups`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| name | varchar(100) |
| course | varchar(100), nullable |
| max_member | int |
| invitation_code | varchar(20), unique |

### `group_members`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| user_id | FK → users |
| group_id | FK → groups |
| role | varchar |
| joined_at | timestamp |

### `tasks`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| title | varchar(150) |
| type | varchar(50) |
| description | text |
| deadline | timestamp |
| group_id | FK → groups |

### `sub_tasks`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| name | varchar(150) |
| task_id | FK → tasks |
| description | text |
| required_ability_id | FK → abilities |
| generation_id | FK → task_generations |
| status | varchar |

### `sub_task_assignments`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| sub_task_id | FK → sub_tasks |
| user_id | FK → users |
| role | varchar |
| status | varchar |

### `task_generations`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| task_id | FK → tasks |
| generated_by | FK → users |
| prompt | text |
| ai_response | text |
| model | varchar(50) |
| version | int |

### `support_files`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| file_name | varchar(255) |
| file_path | varchar(255) |
| task_id | FK → tasks |
| uploaded_by | FK → users |

### `user_ethol_sessions`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| user_id | FK → users |
| ethol_token | text, encrypted |
| ethol_cookies | text, encrypted |

### `password_resets`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| user_id | FK → users |
| token | varchar(255) |
| expires_at | timestamp |

### `user_sessions`
| Column | Type |
|--------|------|
| id | bigint (PK) |
| user_id | FK → users |
| ip_address | varchar(45) |
| user_agent | text |
| login_at | timestamp |
| revoked_at | timestamp |

---

## Architecture

```
Flutter / Web Client
       |
       v
  routes/api.php (Sanctum Middleware)
       |
       v
  Controllers (Auth, User, Group, Task, ETHOL, etc.)
       |
       v
  Services (Business Logic)
       |
       v
  Eloquent Models & PostgreSQL (Supabase)
```

---

## Deployment

Deploy to AWS EC2 with Supabase (PostgreSQL) and HTTPS via Let's Encrypt.

```
Flutter App  →  AWS EC2 (Nginx + PHP-FPM + SSL)  →  Supabase (PostgreSQL)
```

### Quick Start

```bash
# 1. SSH into server
ssh -i "your-key.pem" ubuntu@YOUR_EC2_IP

# 2. Clone
sudo git clone -b backend https://github.com/Dardcor/Sela-Website.git /var/www/sela-website

# 3. Install system packages (PHP, Nginx, Composer, Certbot)
sudo bash /var/www/sela-website/deploy/setup-server.sh

# 4. Configure environment
cd /var/www/sela-website
sudo cp .env.example .env
sudo nano .env    # Set DB_URL, APP_URL, etc.

# 5. Deploy (composer install, migrate, cache, nginx)
sudo bash deploy/deploy.sh

# 6. Setup SSL
sudo bash deploy/setup-ssl.sh

# Done → https://dardcor.acalypha.my.id/api
```

### Updating

```bash
ssh -i "your-key.pem" ubuntu@YOUR_EC2_IP
sudo bash /var/www/sela-website/deploy/deploy.sh
```

### Deploy Scripts

```
deploy/
├── nginx/
│   └── sela-website.conf   # Nginx config
├── setup-server.sh          # Install system packages (once)
├── setup-ssl.sh             # Setup Let's Encrypt SSL (once)
└── deploy.sh                # Deploy app (every update)
```

### Troubleshooting

| Issue | Fix |
|-------|-----|
| 502 Bad Gateway | `sudo systemctl restart php8.2-fpm` |
| Permission denied | `sudo chown -R www-data:www-data /var/www/sela-website/storage` |
| DB connection refused | Check Security Group (outbound 5432) + `.env` credentials |
| Supabase paused | Dashboard → click "Unpause" |
| SSL expired | `sudo certbot renew` |

```bash
# Check Laravel logs
tail -f /var/www/sela-website/storage/logs/laravel.log
```

### Notes

- **AWS Free Tier**: 750 hrs/month EC2 free for 12 months.
- **Supabase Free Tier**: 500MB max, auto-pauses after 7 days inactive.
- **SSL**: 90-day certs, auto-renewed every 60 days by Certbot.
