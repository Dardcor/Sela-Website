# API Reference

This document provides a comprehensive reference for the Sela-Website API.

## Auth

### `POST /api/register`

**Auth:** Not Required
**Description:** Register a new user account.

**Request Body:**
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

### `POST /api/login`

**Auth:** Not Required
**Description:** Authenticate user and receive a bearer token.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| email | string | Yes | email |
| password | string | Yes | string |

**Response:** `200`
```json
{
  "user": {
    "id": 1,
    "username": "johndoe",
    "email": "john@example.com",
    "class": "IF-2022",
    "role": "student"
  },
  "token": "1|abcdef123456"
}
```

### `POST /api/logout`

**Auth:** Required
**Description:** Revoke the current access token.

**Request Body:** None

**Response:** `200`
```json
{
  "message": "Logged out successfully."
}
```

### `GET /api/me`

**Auth:** Required
**Description:** Get the authenticated user profile.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "username": "johndoe",
  "email": "john@example.com",
  "class": "IF-2022",
  "role": "student"
}
```

## Users

### `GET /api/users`

**Auth:** Required
**Description:** List all users.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "username": "johndoe",
    "email": "john@example.com"
  }
]
```

### `GET /api/users/{id}`

**Auth:** Required
**Description:** Get user by ID.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "username": "johndoe",
  "email": "john@example.com"
}
```

### `PUT /api/users/{id}`

**Auth:** Required
**Description:** Update user information.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| username | string | No | max:50 |
| email | string | No | email, max:100, unique |
| password | string | No | min:6 |
| class | string | No | max:100 |
| role | string | No | max:50 |

**Response:** `200`
```json
{
  "id": 1,
  "username": "johndoe_updated",
  "email": "john@example.com"
}
```

### `DELETE /api/users/{id}`

**Auth:** Required
**Description:** Delete a user.

**Request Body:** None

**Response:** `204`

## Abilities

### `GET /api/abilities`

**Auth:** Required
**Description:** List all available abilities.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "name": "Backend Development"
  }
]
```

### `POST /api/abilities`

**Auth:** Required
**Description:** Create a new ability.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| name | string | Yes | max:50 |

**Response:** `201`
```json
{
  "id": 2,
  "name": "Frontend Development"
}
```

### `GET /api/abilities/{ability}`

**Auth:** Required
**Description:** Get specific ability details.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "name": "Backend Development"
}
```

### `PUT /api/abilities/{ability}`

**Auth:** Required
**Description:** Update an ability name.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| name | string | Yes | max:50 |

**Response:** `200`
```json
{
  "id": 1,
  "name": "Fullstack Development"
}
```

### `DELETE /api/abilities/{ability}`

**Auth:** Required
**Description:** Remove an ability.

**Request Body:** None

**Response:** `204`

## User Abilities

### `GET /api/users/{userId}/abilities`

**Auth:** Required
**Description:** List abilities assigned to a specific user.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "user_id": 1,
    "ability_id": 1,
    "level": 5,
    "ability": {
      "id": 1,
      "name": "Backend Development"
    }
  }
]
```

### `POST /api/users/{userId}/abilities`

**Auth:** Required
**Description:** Assign an ability to a user.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| ability_id | integer | Yes | exists:abilities |
| level | integer | No | min:0 |

**Response:** `201`
```json
{
  "id": 1,
  "user_id": 1,
  "ability_id": 1,
  "level": 5
}
```

### `PUT /api/user-abilities/{id}`

**Auth:** Required
**Description:** Update user ability level.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| level | integer | Yes | min:0 |

**Response:** `200`
```json
{
  "id": 1,
  "level": 8
}
```

### `DELETE /api/user-abilities/{id}`

**Auth:** Required
**Description:** Remove an ability assignment from a user.

**Request Body:** None

**Response:** `204`

## Groups

### `GET /api/groups`

**Auth:** Required
**Description:** List all groups.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "name": "PDBL Team A",
    "course": "Web Development",
    "max_member": 5,
    "invitation_code": "TEAM-A-123"
  }
]
```

### `POST /api/groups`

**Auth:** Required
**Description:** Create a new group.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| name | string | Yes | max:100 |
| course | string | No | max:100 |
| max_member | integer | No | min:1 |
| invitation_code | string | No | max:20, unique |

**Response:** `201`
```json
{
  "id": 2,
  "name": "Mobile Dev Group",
  "course": "Mobile Apps",
  "max_member": 4,
  "invitation_code": "MOBI-456"
}
```

### `GET /api/groups/{group}`

**Auth:** Required
**Description:** Get group details.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "name": "PDBL Team A",
  "course": "Web Development"
}
```

### `PUT /api/groups/{group}`

**Auth:** Required
**Description:** Update group information.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| name | string | No | max:100 |
| course | string | No | max:100 |
| max_member | integer | No | min:1 |

**Response:** `200`
```json
{
  "id": 1,
  "name": "PDBL Team A Updated",
  "course": "Advanced Web"
}
```

### `DELETE /api/groups/{group}`

**Auth:** Required
**Description:** Delete a group.

**Request Body:** None

**Response:** `204`

## Group Members

### `GET /api/groups/{groupId}/members`

**Auth:** Required
**Description:** List all members of a group.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "group_id": 1,
    "user_id": 1,
    "role": "leader",
    "user": {
      "id": 1,
      "username": "johndoe"
    }
  }
]
```

### `POST /api/groups/{groupId}/members`

**Auth:** Required
**Description:** Add a user to a group.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| user_id | integer | Yes | exists:users |
| role | string | No | string |

**Response:** `201`
```json
{
  "id": 2,
  "group_id": 1,
  "user_id": 2,
  "role": "member"
}
```

### `PUT /api/group-members/{id}`

**Auth:** Required
**Description:** Update member role in a group.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| role | string | Yes | string |

**Response:** `200`
```json
{
  "id": 2,
  "role": "co-leader"
}
```

### `DELETE /api/groups/{groupId}/members/{userId}`

**Auth:** Required
**Description:** Remove a member from a group.

**Request Body:** None

**Response:** `204`

## Tasks

### `GET /api/tasks`

**Auth:** Required
**Description:** List all tasks.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "title": "Build API Documentation",
    "type": "documentation",
    "group_id": 1
  }
]
```

### `POST /api/tasks`

**Auth:** Required
**Description:** Create a new task for a group.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| title | string | Yes | max:150 |
| type | string | No | max:50 |
| description | string | No | string |
| deadline | date | No | date |
| group_id | integer | Yes | exists:groups |

**Response:** `201`
```json
{
  "id": 2,
  "title": "Design Database Schema",
  "group_id": 1
}
```

### `GET /api/tasks/{task}`

**Auth:** Required
**Description:** Get task details.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "title": "Build API Documentation",
  "type": "documentation"
}
```

### `PUT /api/tasks/{task}`

**Auth:** Required
**Description:** Update task details.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| title | string | No | max:150 |
| type | string | No | max:50 |
| description | string | No | string |
| deadline | date | No | date |
| group_id | integer | No | exists:groups |

**Response:** `200`
```json
{
  "id": 1,
  "title": "Refine API Documentation"
}
```

### `DELETE /api/tasks/{task}`

**Auth:** Required
**Description:** Delete a task.

**Request Body:** None

**Response:** `204`

## Sub Tasks

### `GET /api/tasks/{taskId}/sub-tasks`

**Auth:** Required
**Description:** List sub tasks for a specific task.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "task_id": 1,
    "name": "Write Authentication Docs",
    "status": "pending"
  }
]
```

### `POST /api/tasks/{taskId}/sub-tasks`

**Auth:** Required
**Description:** Create a new sub task.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| name | string | Yes | max:150 |
| description | string | No | string |
| required_ability_id | integer | No | exists:abilities |
| generation_id | integer | No | exists:task_generations |
| status | string | No | string |

**Response:** `201`
```json
{
  "id": 2,
  "task_id": 1,
  "name": "Write User API Docs"
}
```

### `GET /api/sub-tasks/{id}`

**Auth:** Required
**Description:** Get sub task details.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "name": "Write Authentication Docs",
  "status": "pending"
}
```

### `PUT /api/sub-tasks/{id}`

**Auth:** Required
**Description:** Update sub task details.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| name | string | No | max:150 |
| description | string | No | string |
| required_ability_id | integer | No | exists:abilities |
| generation_id | integer | No | exists:task_generations |
| status | string | No | string |

**Response:** `200`
```json
{
  "id": 1,
  "status": "completed"
}
```

### `DELETE /api/sub-tasks/{id}`

**Auth:** Required
**Description:** Delete a sub task.

**Request Body:** None

**Response:** `204`

## Sub Task Assignments

### `GET /api/sub-tasks/{subTaskId}/assignments`

**Auth:** Required
**Description:** List assignments for a sub task.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "sub_task_id": 1,
    "user_id": 1,
    "role": "assignee",
    "status": "in_progress"
  }
]
```

### `POST /api/sub-tasks/{subTaskId}/assignments`

**Auth:** Required
**Description:** Assign a user to a sub task.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| user_id | integer | Yes | exists:users |
| role | string | No | string |
| status | string | No | string |

**Response:** `201`
```json
{
  "id": 2,
  "sub_task_id": 1,
  "user_id": 2,
  "role": "reviewer"
}
```

### `PUT /api/sub-task-assignments/{id}`

**Auth:** Required
**Description:** Update assignment role or status.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| role | string | No | string |
| status | string | No | string |

**Response:** `200`
```json
{
  "id": 2,
  "status": "completed"
}
```

### `DELETE /api/sub-task-assignments/{id}`

**Auth:** Required
**Description:** Remove an assignment.

**Request Body:** None

**Response:** `204`

## Support Files

### `GET /api/tasks/{taskId}/files`

**Auth:** Required
**Description:** List support files for a task.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "task_id": 1,
    "file_path": "uploads/tasks/1/doc.pdf",
    "original_name": "doc.pdf"
  }
]
```

### `POST /api/tasks/{taskId}/files`

**Auth:** Required
**Description:** Upload a support file for a task.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| file | file | Yes | max:10240 KB |

**Note:** Content-Type must be `multipart/form-data`.

**Response:** `201`
```json
{
  "id": 2,
  "file_path": "uploads/tasks/1/new_file.png",
  "original_name": "new_file.png"
}
```

### `GET /api/support-files/{id}`

**Auth:** Required
**Description:** Get support file metadata.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "file_path": "uploads/tasks/1/doc.pdf"
}
```

### `DELETE /api/support-files/{id}`

**Auth:** Required
**Description:** Delete a support file.

**Request Body:** None

**Response:** `204`

## Task Generations

### `GET /api/tasks/{taskId}/generations`

**Auth:** Required
**Description:** List AI generations for a task.

**Request Body:** None

**Response:** `200`
```json
[
  {
    "id": 1,
    "task_id": 1,
    "prompt": "Generate subtasks for API documentation",
    "version": 1
  }
]
```

### `POST /api/tasks/{taskId}/generations`

**Auth:** Required
**Description:** Store an AI generation for a task.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| prompt | string | Yes | string |
| ai_response | string | No | string |
| model | string | No | max:50 |
| version | integer | No | min:1 |

**Response:** `201`
```json
{
  "id": 2,
  "prompt": "Update subtasks prompt",
  "version": 2
}
```

### `GET /api/task-generations/{id}`

**Auth:** Required
**Description:** Get specific generation details.

**Request Body:** None

**Response:** `200`
```json
{
  "id": 1,
  "ai_response": "1. Auth Docs\n2. User Docs"
}
```

### `DELETE /api/task-generations/{id}`

**Auth:** Required
**Description:** Delete a generation.

**Request Body:** None

**Response:** `204`

## ETHOL

### `POST /api/ethol/login`

**Auth:** Not Required
**Description:** Log in via PENS CAS (ETHOL). Auto-creates a user account if one doesn't exist. Returns a Sanctum token — works as an alternative to `POST /api/login`.

**Request Body:**
| Field | Type | Required | Validation |
|-------|------|----------|------------|
| email | string | Yes | string |
| password | string | Yes | string |

**Response:** `200`
```json
{
  "user": {
    "id": 1,
    "username": "Fahroldhi Sukirno",
    "email": "fahroldhisukirno@it.student.pens.ac.id",
    "class": null,
    "role": null,
    "created_at": "2024-03-05T00:00:00.000000Z",
    "updated_at": "2024-03-05T00:00:00.000000Z"
  },
  "token": "1|abcdef123456"
}
```

### `POST /api/ethol/logout`

**Auth:** Required
**Description:** Clear ETHOL session.

**Request Body:** None

**Response:** `200`
```json
{
  "success": true,
  "message": "Logged out from ETHOL successfully."
}
```

### `GET /api/ethol/schedule`

**Auth:** Required
**Description:** Get course schedule.

**Request Body:** None

**Response:** `200`
```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "subjectName": "Pemrograman Dasar",
      "dosen": "Dr. Smith",
      "dosenTitle": "S.Kom., M.T.",
      "kodeKelas": "IF-A",
      "pararel": "1",
      "hari": "Senin",
      "jamAwal": "08:00",
      "jamAkhir": "10:00",
      "nomorHari": 1,
      "ruang": "L-101"
    }
  ]
}
```

### `GET /api/ethol/homework`

**Auth:** Required
**Description:** Get homework list.

**Request Body:** None

**Response:** `200`
```json
{
  "success": true,
  "data": [
    {
      "id": 456,
      "title": "Tugas 1",
      "description": "Implementasi CRUD",
      "deadline": "2024-03-10 23:59:59",
      "status": "not_submitted",
      "subjectName": "Web Dev"
    }
  ]
}
```

### `GET /api/ethol/attendance`

**Auth:** Required
**Description:** Get attendance summary.

**Request Body:** None

**Response:** `200`
```json
{
  "success": true,
  "data": [
    {
      "subjectName": "Web Dev",
      "attendanceRate": 95,
      "history": [
        {
          "date": "2024-03-01",
          "key": "H"
        }
      ]
    }
  ]
}
```

### `GET /api/ethol/token`

**Auth:** Required
**Description:** Get stored ETHOL JWT.

**Request Body:** None

**Response:** `200`
```json
{
  "success": true,
  "data": "eyJ..."
}
```
