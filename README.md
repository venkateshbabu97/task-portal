# 🧭 Role-Based Task Portal (Laravel + Blade)

## 📘 Overview
A simple **Role-Based Task Management Portal** built with **Laravel 11** and **Blade**.  
It supports three user roles with distinct permissions and a clear task lifecycle.  

---

## 👥 User Roles

| Role | Permissions |
|------|--------------|
| **Admin** | View/manage all tasks, assign/reassign users, close/cancel tasks, manage users & labels. |
| **Requester** | Create tasks, edit their own tasks (until *In Progress*), view their own tasks. |
| **Contributor** | View assigned tasks, add comments & attachments. |

---

## ⚙️ Task Lifecycle
```
OPEN → IN_PROGRESS → COMPLETED → VERIFIED (or CANCELLED)
```

---

## 🚀 Features

✅ Authentication (JWT + session)  
✅ Role-based permissions (via Gates)  
✅ Task CRUD operations  
✅ Comments with timestamps & author info  
✅ Audit log for status/assignment changes  
✅ Metrics dashboard (task count, average resolution time)  
✅ Live comment/status updates  
✅ Blade-based clean UI  

---

## 🧑‍💻 Tech Stack

- **Laravel 11**
- **Blade Templates**
- **MySQL**
- **Eloquent ORM**
- **Bootstrap / Tailwind (optional)**
- **PHP 8.2+**
- **XAMPP (Localhost)**

---

## 📦 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/task-portal.git
   cd task-portal
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy `.env`:
   ```bash
   cp .env.example .env
   ```

4. Generate app key:
   ```bash
   php artisan key:generate
   ```

5. Update `.env` (important fields):
   ```env
   APP_URL=http://localhost
   DB_DATABASE=task_portal
   DB_USERNAME=root
   DB_PASSWORD=
   SESSION_DRIVER=file
   CACHE_STORE=file
   ```

6. Run migrations & seed data:
   ```bash
   php artisan migrate --seed
   ```

7. Start the server:
   ```bash
   php artisan serve
   ```
   Visit: [http://localhost:8000](http://localhost:8000)

---

### 🔸 Key Artisan Commands
```bash
php artisan migrate:fresh --seed     # Reset database
php artisan optimize:clear           # Clear cache/config/routes
php artisan route:list               # List available routes
```

---

## 🧠 Project Structure
```
app/
 ├── Http/
 │   ├── Controllers/
 │   ├── Middleware/
 │   ├── Requests/
 ├── Models/
 ├── Policies/
 └── Services/
resources/
 ├── views/
 │   ├── layouts/
 │   ├── tasks/
 │   └── admin/
routes/
 └── web.php
```

---

## 🧪 Tests
Basic feature tests included:
- Role-based access checks
- Task status transitions
- Data validation and ownership checks

Run:
```bash
php artisan test
```

---

## 🧰 Troubleshooting

| Issue | Fix |
|-------|-----|
| “Table not found” errors | Run `php artisan migrate --seed`. |
| Cache/session issues | Set `SESSION_DRIVER=file`, then `php artisan optimize:clear`. |

---

## 📜 License
This project is open-source and free to use for educational or demonstration purposes.
