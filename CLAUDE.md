# Diet & Habit Coach — Project Reference

## What this app does
A multi-user web app for tracking meals, estimating calories (via Claude AI + Open Food Facts), building daily habits, and receiving weekly AI coaching insights.

## Stack
- **Backend:** Laravel 12, MySQL
- **Frontend:** Inertia.js + Vue 3 + Vite + Tailwind CSS
- **AI:** Claude API via `anthropic-php/client` (Haiku for meal estimation, Sonnet for weekly insights)
- **Food data:** Open Food Facts REST API (no key required)
- **PWA:** vite-plugin-pwa (installable on mobile)
- **Deploy:** GitHub Actions → SSH to server (see `.github/workflows/deploy.yml`)

## Design system
- Background: `#F6F4EF` (warm cream)
- Primary: `#4A7259` (sage green)
- Accent: `#E8956D` (warm peach — used for alerts and streaks)
- Border: `#EDE9E0`
- Cards: `rounded-2xl`, inputs/buttons: `rounded-xl`
- Inspired by simple.life — minimal, warm, clean

## Database schema
```
users       → meals       → meal_items → food_items
users       → habits      → habit_logs
users       → ai_insights
```

### Key fields
- `users`: timezone, daily_calorie_goal, daily_protein_goal, daily_carbs_goal, daily_fat_goal
- `meal_items.estimation_method`: `search` (Open Food Facts) or `ai` (Claude estimated)
- `habits`: soft-deleted via `is_active = false`
- `ai_insights.type`: `weekly_summary`, `pattern`, `suggestion`

## Key files
| Path | Purpose |
|------|--------|
| `app/Services/ClaudeService.php` | All Claude API calls |
| `app/Services/OpenFoodFactsService.php` | Food search + local caching |
| `app/Http/Controllers/MealController.php` | Meal CRUD + food search endpoint |
| `app/Http/Controllers/HabitController.php` | Habits + daily log/unlog |
| `app/Http/Controllers/InsightController.php` | Generate + read AI insights |
| `app/Console/Commands/GenerateWeeklyInsights.php` | Scheduled weekly command |
| `routes/console.php` | Scheduler — weekly insights every Sunday 8am |
| `resources/js/Layouts/AppLayout.vue` | Main layout (desktop top nav + mobile bottom nav) |
| `resources/js/Pages/Meals/Create.vue` | Dual-mode meal logging (AI + food search) |

## Local setup
```bash
composer create-project laravel/laravel diet-habit-coach
cd diet-habit-coach
composer require laravel/breeze --dev
php artisan breeze:install vue
# Copy files from this repo over the generated ones
composer require anthropic-php/client
npm install vite-plugin-pwa @tailwindcss/forms
cp .env.example .env && php artisan key:generate
# Set DB_* and ANTHROPIC_API_KEY in .env
php artisan migrate --seed
npm run dev & php artisan serve
```

Default login: `admin@dietcoach.com` / `password`

## Scheduler (server)
Add to crontab so Laravel runs scheduled tasks:
```
* * * * * cd /var/www/diet-habit-coach && php artisan schedule:run >> /dev/null 2>&1
```
This triggers `insights:generate-weekly` every Sunday at 08:00.

## Deployment (when server is ready)
1. Create `.github/workflows/deploy.yml` in the repo
2. Add GitHub secrets: `SERVER_HOST`, `SERVER_USER`, `SERVER_SSH_KEY`
3. Every push to `main` will auto-build and deploy via SSH

## Multi-tenancy rule
Always scope queries to `user_id`. Never fetch records without checking ownership (`abort_if($record->user_id !== $request->user()->id, 403)`).

## AI call conventions
- Meal nutrition estimation → `ClaudeService::estimateMealNutrition()` — uses **Haiku** (fast + cheap)
- Weekly insights → `ClaudeService::generateWeeklyInsight()` — uses **Sonnet** (better reasoning)
- Never call the Anthropic API directly from controllers

## Extending the app
- New feature = new controller + Vue page + route group
- Food data is cached locally in `food_items` to reduce Open Food Facts API calls
- All new AI features go through `ClaudeService`
