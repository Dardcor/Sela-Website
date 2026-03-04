# Sela-Website API Documentation

## Base URL
```
http://127.0.0.1:8001/api
```

---

## Authentication
Endpoint publik tidak memerlukan autentikasi. Endpoint lainnya menggunakan **Laravel Sanctum** (Bearer Token).

### Headers (Wajib untuk semua request)
| Header          | Value                        |
|-----------------|------------------------------|
| `Accept`        | `application/json`           |
| `Authorization` | `Bearer {your_token}`        |

Untuk request `POST`, `PUT`, `PATCH` tambahkan:
| Header         | Value              |
|----------------|--------------------|
| `Content-Type` | `application/json` |

### Response jika tidak authenticated
```json
// 401 Unauthorized
{
    "message": "Unauthenticated."
}
```

---

## HTTP Status Codes
| Code  | Keterangan                                      |
|-------|-------------------------------------------------|
| `200` | OK — Request berhasil                           |
| `201` | Created — Data berhasil dibuat                  |
| `204` | No Content — Data berhasil dihapus              |
| `401` | Unauthorized — Token tidak valid / tidak ada    |
| `403` | Forbidden — Tidak memiliki akses                |
| `404` | Not Found — Data tidak ditemukan                |
| `422` | Unprocessable Entity — Validasi gagal           |

---

## Auth API (Public)

### 1. Register User
Mendaftarkan user baru ke sistem.
```
POST /api/register
```
**Request Body:**
| Field      | Type     | Required | Keterangan                    |
|------------|----------|----------|-------------------------------|
| `username` | `string` | Ya       | Nama pengguna                 |
| `email`    | `string` | Ya       | Alamat email unik             |
| `password` | `string` | Ya       | Password (min 8 karakter)     |
| `class`    | `string` | Tidak    | Nama kelas                    |
| `role`     | `string` | Tidak    | Peran user (e.g. "student")   |

**Example Request:**
```json
{
    "username": "johndoe",
    "email": "john@example.com",
    "password": "password123",
    "class": "IF-44-01",
    "role": "student"
}
```
**Response:** `201 Created`
```json
{
    "user": {
        "id": 1,
        "username": "johndoe",
        "email": "john@example.com",
        "class": "IF-44-01",
        "role": "student",
        "created_at": "2026-03-04T10:00:00.000000Z"
    },
    "token": "1|abc123token..."
}
```

### 2. Login
Melakukan login untuk mendapatkan token akses.
```
POST /api/login
```
**Request Body:**
| Field    | Type     | Required | Keterangan |
|----------|----------|----------|------------|
| `email`    | `string` | Ya       | Email user |
| `password` | `string` | Ya       | Password   |

**Response:** `200 OK`
```json
{
    "user": { "id": 1, "username": "johndoe", "email": "john@example.com", ... },
    "token": "1|abc123token..."
}
```

---

## Auth API (Authenticated)

### 3. Logout
Mencabut token akses yang sedang digunakan.
```
POST /api/logout
```
**Response:** `200 OK`
```json
{
    "message": "Logged out successfully"
}
```

### 4. Get Current User (Me)
Mengambil data user yang sedang login.
```
GET /api/me
```
**Response:** `200 OK`
```json
{
    "id": 1,
    "username": "johndoe",
    "email": "john@example.com",
    "class": "IF-44-01",
    "role": "student"
}
```

---

## Users API

### 5. List Users
Mengambil daftar semua user.
```
GET /api/users
```
**Response:** `200 OK`

### 6. Show User
Mengambil detail user berdasarkan ID.
```
GET /api/users/{id}
```

### 7. Update User
Mengupdate data user.
```
PUT /api/users/{id}
```
**Request Body:** `username`, `email`, `password`, `class`, `role` (semua opsional).

### 8. Delete User
Menghapus user dari sistem.
```
DELETE /api/users/{id}
```
**Response:** `204 No Content`

---

## Abilities API

### 9. List Abilities
Mengambil daftar semua kemampuan (abilities) yang tersedia.
```
GET /api/abilities
```
**Response:** `200 OK`
```json
[
    { "id": 1, "name": "UI/UX Design" },
    { "id": 2, "name": "Backend Development" }
]
```

### 10. Create Ability
Menambah jenis kemampuan baru.
```
POST /api/abilities
```
**Request Body:** `{ "name": "Frontend Development" }`

### 11. Show Ability
```
GET /api/abilities/{ability}
```

### 12. Update Ability
```
PUT /api/abilities/{ability}
```

### 13. Delete Ability
```
DELETE /api/abilities/{ability}
```

---

## User Abilities API

### 14. List User Abilities
Mengambil daftar kemampuan milik user tertentu.
```
GET /api/users/{userId}/abilities
```
**Response:** `200 OK`
```json
[
    {
        "id": 1,
        "user_id": 1,
        "ability_id": 1,
        "level": 4,
        "ability": { "id": 1, "name": "UI/UX Design" }
    }
]
```

### 15. Assign Ability to User
Memberikan kemampuan kepada user.
```
POST /api/users/{userId}/abilities
```
**Request Body:**
| Field        | Type      | Required | Keterangan       |
|--------------|-----------|----------|------------------|
| `ability_id` | `integer` | Ya       | ID Ability       |
| `level`      | `integer` | Tidak    | Level (default 0)|

### 16. Update User Ability Level
Mengubah level kemampuan user.
```
PUT /api/user-abilities/{id}
```
**Request Body:** `{ "level": 5 }`

### 17. Remove User Ability
Menghapus kemampuan dari user.
```
DELETE /api/user-abilities/{id}
```

---

## Groups API

### 18. List Groups
Mengambil semua grup.
```
GET /api/groups
```

### 19. Create Group
Membuat grup baru.
```
POST /api/groups
```
**Request Body:**
| Field             | Type      | Required | Keterangan        |
|-------------------|-----------|----------|-------------------|
| `name`            | `string`  | Ya       | Nama grup         |
| `course`          | `string`  | Tidak    | Nama mata kuliah  |
| `max_member`      | `integer` | Tidak    | Batas maksimal    |
| `invitation_code` | `string`  | Tidak    | Kode undangan     |

### 20. Show Group
```
GET /api/groups/{group}
```

### 21. Update Group
```
PUT /api/groups/{group}
```

### 22. Delete Group
```
DELETE /api/groups/{group}
```

---

## Group Members API

### 23. List Group Members
Mengambil daftar anggota dalam sebuah grup.
```
GET /api/groups/{groupId}/members
```
**Response:** `200 OK`
```json
[
    {
        "id": 1,
        "user_id": 1,
        "group_id": 1,
        "role": "leader",
        "joined_at": "2026-03-04T10:00:00.000000Z",
        "user": { "id": 1, "username": "johndoe", ... }
    }
]
```

### 24. Add Member to Group
Menambahkan user ke dalam grup.
```
POST /api/groups/{groupId}/members
```
**Request Body:** `{ "user_id": 2, "role": "member" }`

### 25. Update Member Role
```
PUT /api/group-members/{id}
```
**Request Body:** `{ "role": "co-leader" }`

### 26. Remove Member from Group
```
DELETE /api/groups/{groupId}/members/{userId}
```

---

## Tasks API

### 27. List Tasks
Mengambil daftar semua task utama.
```
GET /api/tasks
```

### 28. Create Task
Membuat task utama baru.
```
POST /api/tasks
```
**Request Body:**
| Field         | Type      | Required | Keterangan                   |
|---------------|-----------|----------|------------------------------|
| `title`       | `string`  | Ya       | Judul tugas                  |
| `type`        | `string`  | Tidak    | Tipe tugas                   |
| `description` | `string`  | Tidak    | Deskripsi lengkap            |
| `deadline`    | `string`  | Tidak    | Format: YYYY-MM-DD HH:mm:ss  |
| `group_id`    | `integer` | Ya       | ID Grup pemilik task         |

### 29. Show Task
```
GET /api/tasks/{task}
```

### 30. Update Task
```
PUT /api/tasks/{task}
```

### 31. Delete Task
```
DELETE /api/tasks/{task}
```

---

## Sub Tasks API

### 32. List Sub Tasks
Mengambil semua sub-task milik sebuah task utama.
```
GET /api/tasks/{taskId}/sub-tasks
```
**Response:** `200 OK`
```json
[
    {
        "id": 1,
        "name": "Design Database Schema",
        "task_id": 1,
        "status": "in_progress",
        "required_ability": { "id": 2, "name": "Backend Development" },
        "generation": { "id": 1, "model": "gpt-4" }
    }
]
```

### 33. Create Sub Task
```
POST /api/tasks/{taskId}/sub-tasks
```
**Request Body:** `name`, `description`, `required_ability_id`, `generation_id`, `status`.

### 34. Show Sub Task
```
GET /api/sub-tasks/{id}
```

### 35. Update Sub Task
```
PUT /api/sub-tasks/{id}
```

### 36. Delete Sub Task
```
DELETE /api/sub-tasks/{id}
```

---

## Sub Task Assignments API

### 37. List Assignments
Mengambil daftar user yang ditugaskan pada sub-task.
```
GET /api/sub-tasks/{subTaskId}/assignments
```

### 38. Assign User to Sub Task
Menugaskan user ke sub-task tertentu.
```
POST /api/sub-tasks/{subTaskId}/assignments
```
**Request Body:** `{ "user_id": 1, "role": "assignee", "status": "active" }`

### 39. Update Assignment
```
PUT /api/sub-task-assignments/{id}
```

### 40. Remove Assignment
```
DELETE /api/sub-task-assignments/{id}
```

---

## Support Files API

### 41. List Support Files
Mengambil daftar file pendukung untuk sebuah task.
```
GET /api/tasks/{taskId}/files
```

### 42. Upload Support File
Mengunggah file baru.
```
POST /api/tasks/{taskId}/files
```
**Request Body (Multipart/Form-Data):**
| Field  | Type   | Required | Keterangan              |
|--------|--------|----------|-------------------------|
| `file` | `file` | Ya       | File (Maksimal 10MB)    |

### 43. Show Support File
```
GET /api/support-files/{id}
```

### 44. Delete Support File
```
DELETE /api/support-files/{id}
```

---

## Task Generations (AI) API

### 45. List Task Generations
Mengambil riwayat generasi AI untuk sebuah task.
```
GET /api/tasks/{taskId}/generations
```

### 46. Create Task Generation
Menyimpan hasil generasi prompt AI.
```
POST /api/tasks/{taskId}/generations
```
**Request Body:**
| Field         | Type     | Required | Keterangan        |
|---------------|----------|----------|-------------------|
| `prompt`      | `text`   | Ya       | Prompt yang dikirim|
| `ai_response` | `text`   | Tidak    | Jawaban dari AI   |
| `model`       | `string` | Tidak    | Nama model AI     |
| `version`     | `integer`| Tidak    | Versi generasi    |

### 47. Show Task Generation
```
GET /api/task-generations/{id}
```

### 48. Delete Task Generation
```
DELETE /api/task-generations/{id}
```

---

## Database Schema (12 Tables)

### 1. `users`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `username` | `varchar(50)` | |
| `email` | `varchar(100)` | Unique |
| `password` | `varchar(255)` | |
| `class` | `varchar(100)` | Nullable |
| `role` | `varchar(50)` | Nullable |

### 2. `abilities`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `name` | `varchar(50)` | Nama skill |

### 3. `groups`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `name` | `varchar(100)` | |
| `course` | `varchar(100)` | Nullable |
| `max_member` | `int` | |
| `invitation_code` | `varchar(20)` | Unique |

### 4. `tasks`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `title` | `varchar(150)` | |
| `type` | `varchar(50)` | |
| `description` | `text` | |
| `deadline` | `timestamp` | |
| `group_id` | `foreignId` | FK to groups |

### 5. `task_generations`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `task_id` | `foreignId` | FK to tasks |
| `generated_by` | `foreignId` | FK to users |
| `prompt` | `text` | |
| `ai_response` | `text` | |
| `model` | `varchar(50)` | |
| `version` | `int` | |

### 6. `user_abilities`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `user_id` | `foreignId` | FK to users |
| `ability_id` | `foreignId` | FK to abilities |
| `level` | `int` | Default 0 |

### 7. `password_resets`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `user_id` | `foreignId` | FK to users |
| `token` | `varchar(255)` | |
| `expires_at` | `timestamp` | |

### 8. `group_members`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `user_id` | `foreignId` | FK to users |
| `group_id` | `foreignId` | FK to groups |
| `role` | `varchar` | |
| `joined_at` | `timestamp` | |

### 9. `sub_tasks`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `name` | `varchar(150)` | |
| `task_id` | `foreignId` | FK to tasks |
| `description` | `text` | |
| `required_ability_id` | `foreignId` | FK to abilities |
| `generation_id` | `foreignId` | FK to task_generations |
| `status` | `varchar` | |

### 10. `sub_task_assignments`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `sub_task_id` | `foreignId` | FK to sub_tasks |
| `user_id` | `foreignId` | FK to users |
| `role` | `varchar` | |
| `status` | `varchar` | |

### 11. `user_sessions`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `user_id` | `foreignId` | FK to users |
| `ip_address` | `varchar(45)` | |
| `user_agent` | `text` | |
| `login_at` | `timestamp` | |
| `revoked_at` | `timestamp` | |

### 12. `support_files`
| Column | Type | Keterangan |
|--------|------|------------|
| `id` | `bigint` | Primary Key |
| `file_name` | `varchar(255)` | |
| `file_path` | `varchar(255)` | |
| `task_id` | `foreignId` | FK to tasks |
| `uploaded_by` | `foreignId` | FK to users |

---

## Architecture
```
Flutter / Web Client
       |
       v
  routes/api.php (Sanctum Middleware)
       |
       v
  Controllers (Auth, User, Group, Task, etc.)
       |
       v
  Eloquent Models & Database (MySQL/PostgreSQL)
```
