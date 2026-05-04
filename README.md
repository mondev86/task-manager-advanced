# 🚀 TaskManager Advanced

> A modern, full-stack task management system built with Laravel 12, Vue 3, and TypeScript — designed for teams that need structured collaboration and real-time project tracking.

[![Laravel](https://img.shields.io/badge/Laravel-12-red?style=flat&logo=laravel)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3-green?style=flat&logo=vuedotjs)](https://vuejs.org)
[![TypeScript](https://img.shields.io/badge/TypeScript-5-blue?style=flat&logo=typescript)](https://typescriptlang.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4-cyan?style=flat&logo=tailwindcss)](https://tailwindcss.com)
[![Pest](https://img.shields.io/badge/Tests-Pest-5B2C6F?style=flat&logo=php)](https://pestphp.com)

---

## 📋 Overview

**TaskManager Advanced** is a comprehensive project management platform that enables teams to collaborate effectively through structured **Teams → Projects → Tasks** hierarchies. Built with modern best practices, it features real-time commenting, role-based access control, priority management, and an analytics dashboard.

Perfect for demonstrating:
- ✅ Full-stack development with PHP & JavaScript ecosystems
- ✅ Modern Vue 3 + Composition API + TypeScript
- ✅ Laravel 12 with Eloquent ORM & Policies
- ✅ Inertia.js for SPA-like experience without API complexity
- ✅ Clean architecture & test-driven development

---

## 💻 Tech Stack

### Backend
| Technology | Purpose |
|---|---|
| **Laravel 12** | PHP framework with MVC architecture |
| **PHP 8.2+** | Latest PHP features & attributes |
| **Laravel Fortify** | Authentication scaffolding |
| **Laravel Sanctum** | API token management |
| **Laravel Telescope** | Debugging & performance monitoring |
| **MySQL** | Relational database with Eloquent ORM |
| **Pest PHP** | Elegant testing framework |

### Frontend
| Technology | Purpose |
|---|---|
| **Vue 3** | Reactive UI with Composition API |
| **TypeScript** | Type-safe JavaScript |
| **Inertia.js 2.0** | Seamless Laravel ↔ Vue bridge |
| **Tailwind CSS 4** | Utility-first styling |
| **Reka UI** | Accessible component library |
| **Lucide Icons** | Beautiful icon system |
| **Vite 7** | Lightning-fast HMR & builds |

### Code Quality
- **ESLint** + **Prettier** — JavaScript/TypeScript formatting
- **Laravel Pint** — PHP code style fixer
- **Larastan** — Static analysis for Laravel
- **Husky-ready** — Git hooks for quality gates

---

## ✨ Key Features

### 1. 👥 Team Management
- Create and manage multiple teams
- Invite members via email
- Role-based access: **Super Admin**, **Admin**, **Member**
- Team member directory with detailed profiles

### 2. 📁 Project Organization
- Organize work into projects within teams
- Project descriptions, metadata, and progress tracking
- Quick project switching and filtering

### 3. ✅ Advanced Task Management
| Feature | Details |
|---|---|
| **Status Tracking** | Pending → In Progress → Completed |
| **Priority Levels** | Low, Medium, High with visual indicators |
| **Due Dates** | Calendar integration with overdue alerts |
| **Assignment** | Assign tasks to team members |
| **Filtering** | Filter by status, priority, assignee |
| **Pagination** | Efficient task list rendering |

### 4. 💬 Real-Time Collaboration
- Comment on tasks with rich text
- Track comment authors and timestamps
- Edit/delete own comments
- Admin controls for comment moderation

### 5. 📊 Analytics Dashboard
- **Statistics Cards**: Total teams, projects, tasks, completion rate
- **Progress Bars**: Visual task status distribution
- **Upcoming Tasks**: Personalized task list with due dates
- **Recent Teams**: Quick access to active collaborations

### 6. 🔐 Security & Authentication
- User registration with email verification
- Two-Factor Authentication (2FA) via Fortify
- Password reset functionality
- Role-based authorization policies
- Team membership validation on all operations
- CSRF protection & XSS prevention

---

## 🏗️ Architecture

### Database Schema

```
Users
├── id, name, email, password
├── Roles (Many-to-Many)
├── Teams (Many-to-Many)
└── 2FA fields

Teams
├── id, name, description, created_by
├── Users (Belongs-to-Many)
├── Projects (Has-Many)
└── Creator (Belongs-to User)

Projects
├── id, team_id, name, description
├── Team (Belongs-to)
├── Tasks (Has-Many)
└── Creator (Belongs-to User)

Tasks
├── id, project_id, title, description
├── status, priority, due_date
├── created_by, assigned_to
└── Comments (Has-Many)

Comments
├── id, task_id, user_id, content
└── Relationships to Task & User
```

### Project Structure

```
task-manager-advanced/
├── app/
│   ├── Models/              # User, Team, Project, Task, Comment, Role
│   ├── Http/
│   │   ├── Controllers/     # Dashboard, Teams, Projects, Tasks, Comments
│   │   └── Middleware/
│   └── Policies/            # Authorization logic
├── resources/
│   ├── js/
│   │   ├── Pages/           # Vue 3 + TypeScript components
│   │   │   ├── Auth/
│   │   │   ├── Teams/
│   │   │   ├── Projects/
│   │   │   ├── Tasks/
│   │   │   └── Settings/
│   │   ├── layouts/         # GuestLayout, AuthenticatedLayout
│   │   ├── Components/      # Reusable UI components
│   │   ├── composables/     # Vue composables
│   │   └── lib/           # Utility functions
│   └── css/
├── routes/
│   ├── web.php              # Inertia routes
│   ├── auth.php             # Fortify routes
│   └── settings.php        # Settings routes
├── database/
│   ├── migrations/          # 17+ migration files
│   ├── seeders/
│   └── factories/
└── tests/                   # Pest PHP test suite
```

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+ with extensions (mbstring, xml, curl, zip)
- Composer 2.x
- Node.js 18+ and npm
- MySQL 8.0+ or MariaDB
- Laravel Herd (recommended) or Valet/Sail

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/mondev86/task-manager-advanced.git
cd task-manager-advanced

# 2. Install PHP dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
# DB_CONNECTION=mysql
# DB_DATABASE=task_manager_advanced

# 5. Run migrations
php artisan migrate

# 6. Install frontend dependencies
npm install

# 7. Start development servers
composer run dev
# This starts: PHP server + Vite HMR + Queue worker
```

### Access
- **Herd**: `http://task-manager-advanced.test`
- **Artisan serve**: `http://localhost:8000`

---

## 🧪 Testing

The project uses **Pest PHP** for an expressive testing experience.

```bash
# Run all tests
composer test

# Run with coverage
php artisan test --coverage

# Run specific test suite
php artisan test --filter=DashboardTest
```

**Test Coverage**:
- ✅ Authentication flows (register, login, 2FA, password reset)
- ✅ Dashboard statistics and permissions
- ✅ Team CRUD operations
- ✅ Project management within teams
- ✅ Task creation, filtering, and status updates
- ✅ Comment creation and moderation

---

## 📦 Available Scripts

### Composer
```bash
composer test          # Run test suite
composer run dev       # Start full dev environment
composer run dev:ssr  # Dev with Server-Side Rendering
```

### NPM
```bash
npm run dev            # Vite dev server with HMR
npm run build          # Production build
npm run build:ssr      # Build with SSR
npm run lint           # ESLint check
npm run format         # Prettier format
```

---

## 🎨 UI Highlights

- **Design System**: Custom Tailwind CSS theme with Indigo primary
- **Status Colors**: Pending (Gray), In Progress (Blue), Completed (Green)
- **Priority Indicators**: High (Red), Medium (Orange), Low (Blue)
- **Responsive**: Mobile-first design with hamburger navigation
- **Accessibility**: ARIA-compliant components via Reka UI
- **Interactive**: Smooth transitions and hover states

---

## 🔐 Security Features

- ✅ CSRF protection via Inertia.js
- ✅ SQL injection prevention with Eloquent ORM
- ✅ XSS protection with Vue's template escaping
- ✅ Two-factor authentication (Fortify)
- ✅ Role-based access control (Policies)
- ✅ Team membership validation
- ✅ Password hashing (bcrypt)
- ✅ Email verification for new accounts

---

## 📈 What Recruiters Should Know

This project demonstrates:
1. **Modern PHP**: Laravel 12 with latest features, service containers, and dependency injection
2. **Type-Safe Frontend**: Full TypeScript integration with Vue 3 Composition API
3. **SPA Architecture**: Inertia.js for seamless server-client communication without API complexity
4. **Database Design**: Proper relationships, migrations, and Eloquent ORM usage
5. **Testing Mindset**: Pest PHP with feature and unit tests
6. **Code Quality**: Linting, formatting, and static analysis tools configured
7. **Security Awareness**: Policies, validation, sanitization, and authentication best practices
8. **Real-World Features**: Not a tutorial app — includes role-based access, team management, and collaboration

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 👤 Author

**mondev86**
- GitHub: [@mondev86](https://github.com/mondev86)
- Project Link: [task-manager-advanced](https://github.com/mondev86/task-manager-advanced)

---

<div align="center">
  <sub>Built with ❤️ using Laravel + Vue + TypeScript</sub>
</div>
