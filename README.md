# Task Management System

A task management application built with Laravel 12 (API) and Vue 3 (SPA).

## Features

- Task CRUD (Create, Read, Update, Delete)
- Search by task title (`search` query param)
- Pagination (10 tasks per page)
- Priority support: `low`, `medium`, `high`
- Status support: `pending`, `in_progress`, `completed`
- Demo task data via seeder

## Tech Stack

- Backend: Laravel 12, PHP 8.2+
- Frontend: Vue 3, Vue Router, Vite
- Styling/JS: Bootstrap 5, Axios
- Database: MySQL/SQLite (based on Laravel configuration)

## Requirements

- PHP `>= 8.2`
- Composer
- Node.js `>= 18`
- npm
- Database server (if you are not using SQLite)

## Quick Start

1. Clone the project:

```bash
git clone <your-repo-url>
cd task_management_system
```

2. Install backend dependencies:

```bash
composer install
```

3. Set up the environment file:

```bash
copy .env.example .env
php artisan key:generate
```

4. Configure database settings in `.env`, then run migrations and seeders:

```bash
php artisan migrate --seed
```

5. Install frontend dependencies:

```bash
npm install
```

6. Run development servers (recommended):

```bash
composer run dev
```

This runs the Laravel server, queue listener, logs, and Vite together.

## Alternative Run Commands

You can also run them separately:

```bash
php artisan serve
npm run dev
```

## Build For Production

```bash
npm run build
```

## API Endpoints

Base URL: `http://127.0.0.1:8000/api`

| Method | Endpoint | Description |
|---|---|---|
| GET | `/tasks` | Task list (pagination) |
| GET | `/tasks?search=keyword` | Search by title |
| GET | `/tasks/{id}` | Get a single task |
| POST | `/tasks` | Create a new task |
| PUT/PATCH | `/tasks/{id}` | Task update |
| DELETE | `/tasks/{id}` | Task delete |

## Request Payload (Create/Update)

```json
{
	"title": "Build task dashboard",
	"description": "Create dashboard UI for task monitoring",
	"assigned_to": "John",
	"priority": "high",
	"status": "in_progress",
	"start_date": "2026-04-15 09:00:00",
	"end_date": "2026-04-20 18:00:00"
}
```

## Seeder Information

- Running `php artisan migrate --seed` will:
- Create 1 demo user (`test@example.com`)
- Insert 20 demo tasks

## Frontend Routes

- `/task-list`
- `/task-create`
- `/task-edit/:id`
- `/task-detail/:id`

## Testing

```bash
composer run test
```

## Project Scripts

```bash
composer run setup   # install + env + key + migrate + npm install + build
composer run dev     # runs development processes together
composer run test    # runs the test suite
```

## License

This project is released under the MIT License.
