# Diet & Habit Coach

A minimalistic Diet & Habit Coach web app built with **Laravel 12**, **Inertia.js**, **Vue 3**, and **Tailwind CSS**.

## Stack

- **Backend:** Laravel 12
- **Frontend:** Inertia.js + Vue 3 + Vite
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **Auth:** Laravel Breeze (Inertia/Vue preset) — single user, no registration

## Setup

```bash
# 1. Install Laravel
composer create-project laravel/laravel diet-habit-coach
cd diet-habit-coach

# 2. Install Breeze (Inertia + Vue)
composer require laravel/breeze --dev
php artisan breeze:install vue

# 3. Copy env and configure
cp .env.example .env
php artisan key:generate

# 4. Create MySQL database and update .env with your credentials

# 5. Run migrations and seed the single user
php artisan migrate --seed

# 6. Start dev servers
npm install && npm run dev
php artisan serve
```

## Default Login

| Field    | Value                 |
|----------|-----------------------|
| Email    | `admin@dietcoach.com` |
| Password | `password`            |

> Change credentials via the Profile page after first login.

## Custom Files (override Breeze defaults)

After running `breeze:install vue`, copy these files from this repo over the generated ones:

- `routes/web.php` — redirects `/` to login, no registration
- `routes/auth.php` — login/logout only
- `resources/js/Layouts/AppLayout.vue` — minimal nav layout
- `resources/js/Pages/Auth/Login.vue` — clean login page
- `resources/js/Pages/Dashboard.vue` — overview dashboard
- `resources/js/Pages/Profile/Edit.vue` — profile & password update
- `database/seeders/DatabaseSeeder.php`
- `database/seeders/UserSeeder.php`
