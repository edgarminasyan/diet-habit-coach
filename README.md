# Diet & Habit Coach

A minimalistic, multi-user Diet & Habit Coach web app.

**Stack:** Laravel 12 · Inertia.js · Vue 3 · Tailwind CSS · MySQL · Claude AI · PWA

## Features
- Log meals with AI calorie estimation (Claude Haiku) or food database search (Open Food Facts — 2M+ products)
- Daily habit tracking with streaks
- 30-day progress charts
- Weekly AI coaching insights (Claude Sonnet)
- Installable as a mobile PWA
- Auto-deploy via GitHub Actions (ready to wire when server exists)

## Setup

```bash
# 1. Create Laravel project
composer create-project laravel/laravel diet-habit-coach
cd diet-habit-coach

# 2. Install Breeze
composer require laravel/breeze --dev
php artisan breeze:install vue

# 3. Copy custom files from this repo
git clone https://github.com/edgarminasyan/diet-habit-coach.git /tmp/dhc
cp -r /tmp/dhc/app /tmp/dhc/routes /tmp/dhc/database /tmp/dhc/resources . 
cp /tmp/dhc/vite.config.js /tmp/dhc/tailwind.config.js /tmp/dhc/.env.example .

# 4. Install extra packages
composer require anthropic-php/client
npm install vite-plugin-pwa @tailwindcss/forms

# 5. Configure
cp .env.example .env
php artisan key:generate
# Edit .env — set DB_DATABASE, DB_USERNAME, DB_PASSWORD, ANTHROPIC_API_KEY

# 6. Migrate and seed
php artisan migrate --seed

# 7. Start
npm run dev
php artisan serve
```

## Login
| Field | Value |
|---|---|
| Email | `admin@dietcoach.com` |
| Password | `password` |

See `CLAUDE.md` for full architecture, conventions, and deployment instructions.
