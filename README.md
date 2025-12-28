# Task Management Platform – Technical Assessment

This repository demonstrates a **scalable task management platform design**, including:

- System architecture
- Database schema
- API implementation (Laravel)
- Security hardening
- Real-time frontend search
- Debugging strategy
- Deployment considerations

---

## 1. System Architecture

Browser (Vanilla JS)
↓ HTTPS/JSON
Laravel API (REST)
├── Auth (Sanctum)
├── Validation Layer
├── Service Layer
├── Events / Jobs
↓
Database (MySQL/PostgreSQL)
↓
Redis (cache & queues)
↓
Queue Workers (Horizon)

**Components:**

- **Frontend:** Real-time search and task management UI (vanilla JS)
- **Backend:** Laravel REST API, handles transactions and events
- **Database:** MySQL/PostgreSQL
- **Cache & Queues:** Redis
- **Workers:** Asynchronous processing with Laravel Horizon

---

## 2. Database Schema

**Tables:**

- `users`: id, name, email, password
- `projects`: id, name, owner_id
- `tasks`: id, project_id, title, priority, status
- `subtasks`: id, task_id, title, completed
- `task_user` (pivot): task_id, user_id
- `notifications`: id, user_id, payload, read_at

**Indexes:**

- `tasks.project_id`
- `task_user.user_id`
- Full-text index on `tasks.title` for search

---

## 3. API Design

**Routes:**

- `POST /api/projects/{project}/tasks/bulk` → Bulk task creation
- `GET /api/search/tasks?q=` → Real-time search

**Example Payload:**

```json
{
  "tasks": [
    {
      "title": "Build API",
      "priority": "high",
      "assignees": [1, 2],
      "subtasks": [{ "title": "Design DB" }, { "title": "Write migrations" }]
    }
  ]
}
```

Example Response:
{
"status": "success",
"message": "Tasks created successfully"
}

## 4. Backend Validation Rules

.Tasks array required, minimum 1

.Task title required, max 255 characters

.Priority: low, medium, high

.Assignees must exist in users

.Subtasks array optional, each with title

## 5. Security Hardening

.SQL Injection: Use Eloquent ORM / Query Builder

.XSS: Escape outputs; API returns JSON only

.CSRF: Laravel Sanctum middleware for stateful requests

.Rate limiting: throttle:60,1 middleware

.Token theft: HTTPS, HttpOnly cookies, short TTL

.Weak authentication: Hash passwords, email verification, optional 2FA

## 6. Frontend – Real-Time Search

Features:

.Debounced API calls

.Highlight matched terms

.Keyboard navigation

.Empty/error state handling

Files: frontend/index.html, frontend/live-search.js

## 7. Debugging Strategy

.Replicate errors with cache ON/OFF

.Analyze Laravel logs & Redis keys

.Isolate cache and queue layers

.Identify root cause (race conditions / stale cache)

.Apply fixes: atomic cache keys, idempotent jobs, proper cache invalidation

## 8. Deployment Considerations

.Dockerized Laravel + Nginx + PHP-FPM

.Redis for cache and queues

.CI/CD via GitHub Actions

.Horizontal scaling, load balancing

.Monitoring via Laravel Horizon & logging
