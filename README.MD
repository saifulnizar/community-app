# Community App with Laravel, Livewire, Filament, and REST API

A modern community-based web app built with Laravel 12, Livewire 3, Filament 3, UUIDs, RESTful API, role-based access control, tagging, and content moderation.

---

## 🚀 Tech Stack

- **Laravel 12** – Main framework (PHP 8.2+)
- **Livewire 3** – Interactive frontend
- **Filament 3.3** – Admin panel and content management
- **Spatie Laravel-Permission** – Role & permission management
- **MySQL** – Relational database
- **UUIDs** – For model IDs
- **RESTful API** – For mobile or external use
- **Sanctum** – Token-based API authentication

---

## 🛠️ Installation Guide

### Requirements

- PHP 8.2+
- Composer
- MySQL
- Node.js & NPM (for assets)
- Git

### 1. Clone the Repo

```bash
git clone https://github.com/saifulnizar/community-app.git
cd community-app
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=RoleInit
php artisan serve
```


###
👩‍💼 Admin Panel (Filament)
👩‍💼 User Panel Simple Livewire
Login
```
admin@comuity.com
password

jhon@comuity.com
password
```

### API Authentication

```
Authorization: Bearer {token}

| Method | Endpoint               | Auth  | Description                       |
| ------ | ---------------------- | ----- | --------------------------------- |
| POST   | `/api/login`           | No    | Login user, returns token         |
| POST   | `/api/logout`          | Yes   | Logout & revoke token             |
| GET    | `/api/posts`           | No    | List all approved posts           |
| GET    | `/api/posts/{id}`      | No    | Show single post                  |
| POST   | `/api/posts`           | Yes   | Create new post                   |
| PUT    | `/api/posts/{id}`      | Yes   | Update post (owner or admin only) |
| DELETE | `/api/posts/{id}`      | Yes   | Delete post (owner or admin only) |
| GET    | `/api/comments`        | No    | List all approved comments        |
| POST   | `/api/comments`        | Yes   | Create comment                    |
| DELETE | `/api/comments/{id}`   | Yes   | Delete comment (owner or admin)   |
| GET    | `/api/tags`            | No    | List all tags                     |
| POST   | `/api/tags`            | Admin | Create new tag                    |
| DELETE | `/api/tags/{id}`       | Admin | Delete tag                        |
| POST   | `/api/posts/{id}/like` | Yes   | Like or Unlike post               |

```



---
## 📬 Postman Collection

Kamu bisa mengunduh dan mengimpor Postman Collection dari file berikut:

👉 [api-collection.json](./api-collection.json)

