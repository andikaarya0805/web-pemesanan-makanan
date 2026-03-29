-- NutriBox PostgreSQL Dump (Supabase Compatible)

-- 1. Create Tables

-- cache
CREATE TABLE "cache" (
  "key" varchar(255) PRIMARY KEY,
  "value" text NOT NULL,
  "expiration" bigint NOT NULL
);
CREATE INDEX "cache_expiration_index" ON "cache" ("expiration");

-- cache_locks
CREATE TABLE "cache_locks" (
  "key" varchar(255) PRIMARY KEY,
  "owner" varchar(255) NOT NULL,
  "expiration" bigint NOT NULL
);
CREATE INDEX "cache_locks_expiration_index" ON "cache_locks" ("expiration");

-- contact_messages
CREATE TABLE "contact_messages" (
  "id" BIGSERIAL PRIMARY KEY,
  "name" varchar(100) NOT NULL,
  "email" varchar(100) NOT NULL,
  "phone" varchar(20) DEFAULT NULL,
  "subject" varchar(20) NOT NULL CHECK (subject IN ('general','order','delivery','nutrition','partnership','other')),
  "message" text NOT NULL,
  "status" varchar(10) NOT NULL DEFAULT 'new' CHECK (status IN ('new','read','replied')),
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- failed_jobs
CREATE TABLE "failed_jobs" (
  "id" BIGSERIAL PRIMARY KEY,
  "uuid" varchar(255) UNIQUE NOT NULL,
  "connection" text NOT NULL,
  "queue" text NOT NULL,
  "payload" text NOT NULL,
  "exception" text NOT NULL,
  "failed_at" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- jobs
CREATE TABLE "jobs" (
  "id" BIGSERIAL PRIMARY KEY,
  "queue" varchar(255) NOT NULL,
  "payload" text NOT NULL,
  "attempts" smallint NOT NULL,
  "reserved_at" integer DEFAULT NULL,
  "available_at" integer NOT NULL,
  "created_at" integer NOT NULL
);
CREATE INDEX "jobs_queue_index" ON "jobs" ("queue");

-- job_batches
CREATE TABLE "job_batches" (
  "id" varchar(255) PRIMARY KEY,
  "name" varchar(255) NOT NULL,
  "total_jobs" integer NOT NULL,
  "pending_jobs" integer NOT NULL,
  "failed_jobs" integer NOT NULL,
  "failed_job_ids" text NOT NULL,
  "options" text,
  "cancelled_at" integer DEFAULT NULL,
  "created_at" integer NOT NULL,
  "finished_at" integer DEFAULT NULL
);

-- menu_items
CREATE TABLE "menu_items" (
  "id" BIGSERIAL PRIMARY KEY,
  "name" varchar(100) NOT NULL,
  "description" text,
  "calories" integer DEFAULT NULL,
  "category" varchar(50) NOT NULL,
  "dietary_type" varchar(50) NOT NULL,
  "ingredients" text,
  "image_url" varchar(255) DEFAULT NULL,
  "is_active" boolean NOT NULL DEFAULT true,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- migrations
CREATE TABLE "migrations" (
  "id" SERIAL PRIMARY KEY,
  "migration" varchar(255) NOT NULL,
  "batch" integer NOT NULL
);

-- plans
CREATE TABLE "plans" (
  "id" BIGSERIAL PRIMARY KEY,
  "name" varchar(50) NOT NULL,
  "description" text,
  "price_per_week" decimal(10,2) NOT NULL,
  "meals_per_week" integer NOT NULL,
  "features" json DEFAULT NULL,
  "is_active" boolean NOT NULL DEFAULT true,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- users
CREATE TABLE "users" (
  "id" BIGSERIAL PRIMARY KEY,
  "name" varchar(255) NOT NULL,
  "email" varchar(255) UNIQUE NOT NULL,
  "email_verified_at" timestamp NULL DEFAULT NULL,
  "password" varchar(255) NOT NULL,
  "phone" varchar(20) DEFAULT NULL,
  "address" text,
  "role" varchar(10) NOT NULL DEFAULT 'user' CHECK (role IN ('user','admin','manager')),
  "dietary_preferences" varchar(20) NOT NULL DEFAULT 'none' CHECK (dietary_preferences IN ('none','vegetarian','vegan','keto','paleo','mediterranean')),
  "allergies" text,
  "goals" varchar(20) NOT NULL DEFAULT 'general-health' CHECK (goals IN ('weight-loss','weight-gain','maintain','muscle-gain','general-health')),
  "remember_token" varchar(100) DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- subscriptions
CREATE TABLE "subscriptions" (
  "id" BIGSERIAL PRIMARY KEY,
  "user_id" bigint NOT NULL REFERENCES "users" ("id") ON DELETE CASCADE,
  "plan_id" bigint NOT NULL REFERENCES "plans" ("id"),
  "start_date" date NOT NULL,
  "duration_weeks" integer NOT NULL,
  "total_price" decimal(10,2) NOT NULL,
  "payment_method" varchar(255) DEFAULT NULL,
  "status" varchar(10) NOT NULL DEFAULT 'active' CHECK (status IN ('active','paused','cancelled','completed')),
  "delivery_address" text NOT NULL,
  "notes" text,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- meal_selections
CREATE TABLE "meal_selections" (
  "id" BIGSERIAL PRIMARY KEY,
  "subscription_id" bigint NOT NULL REFERENCES "subscriptions" ("id") ON DELETE CASCADE,
  "menu_item_id" bigint NOT NULL REFERENCES "menu_items" ("id") ON DELETE CASCADE,
  "week_number" integer NOT NULL DEFAULT 1,
  "delivery_date" date DEFAULT NULL,
  "status" varchar(255) NOT NULL DEFAULT 'pending',
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- orders
CREATE TABLE "orders" (
  "id" BIGSERIAL PRIMARY KEY,
  "subscription_id" bigint NOT NULL REFERENCES "subscriptions" ("id"),
  "week_start_date" date NOT NULL,
  "delivery_date" date NOT NULL,
  "status" varchar(10) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','preparing','delivered','cancelled')),
  "delivery_notes" text,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- password_reset_tokens
CREATE TABLE "password_reset_tokens" (
  "email" varchar(255) PRIMARY KEY,
  "token" varchar(255) NOT NULL,
  "created_at" timestamp NULL DEFAULT NULL
);

-- sessions
CREATE TABLE "sessions" (
  "id" varchar(255) PRIMARY KEY,
  "user_id" bigint DEFAULT NULL REFERENCES "users" ("id"),
  "ip_address" varchar(45) DEFAULT NULL,
  "user_agent" text,
  "payload" text NOT NULL,
  "last_activity" integer NOT NULL
);
CREATE INDEX "sessions_user_id_index" ON "sessions" ("user_id");
CREATE INDEX "sessions_last_activity_index" ON "sessions" ("last_activity");

-- weekly_menus
CREATE TABLE "weekly_menus" (
  "id" BIGSERIAL PRIMARY KEY,
  "week_start_date" date NOT NULL,
  "plan_id" bigint NOT NULL REFERENCES "plans" ("id"),
  "menu_items" json DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL
);

-- 2. Insert Data

-- menu_items
INSERT INTO "menu_items" ("id", "name", "description", "calories", "category", "dietary_type", "ingredients", "image_url", "is_active", "created_at", "updated_at") VALUES
(1, 'Quinoa Buddha Bowl', 'Quinoa, alpukat, edamame, wortel, dan tahini dressing', 420, 'lunch', 'vegetarian', NULL, '/images/menu5.png', true, '2026-03-29 05:56:40', '2026-03-29 08:18:02'),
(2, 'Grilled Salmon', 'Salmon panggang dengan sayuran kukus dan nasi merah', 380, 'dinner', 'regular', NULL, '/images/menu1.png', true, '2026-03-29 05:56:40', '2026-03-29 08:18:02'),
(3, 'Veggie Wrap', 'Tortilla gandum dengan hummus, sayuran segar, dan feta', 350, 'lunch', 'vegetarian', NULL, '/images/menu2.png', true, '2026-03-29 05:56:40', '2026-03-29 08:18:02'),
(4, 'Green Smoothie Bowl', 'Smoothie bayam, pisang, mangga dengan granola topping', 280, 'breakfast', 'vegan', NULL, '/images/menu3.png', true, '2026-03-29 05:56:40', '2026-03-29 08:18:02'),
(5, 'Chicken Teriyaki', 'Ayam teriyaki dengan nasi dan sayuran', 450, 'dinner', 'regular', NULL, '/images/menu4.png', true, '2026-03-29 05:56:40', '2026-03-29 08:18:02'),
(6, 'Avocado Toast', 'Roti gandum dengan alpukat dan telur', 320, 'Lunch', 'Standard', NULL, '/images/menu6.png', true, '2026-03-29 05:56:40', '2026-03-29 08:18:02');

-- migrations
INSERT INTO "migrations" ("id", "migration", "batch") VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_02_000001_create_plans_table', 1),
(5, '2025_01_02_000002_create_menu_items_table', 1),
(6, '2025_01_02_000003_create_subscriptions_table', 1),
(7, '2025_01_02_000004_create_orders_table', 1),
(8, '2025_01_02_000005_create_contact_messages_table', 1),
(9, '2025_01_02_000006_create_weekly_menus_table', 1),
(10, '2026_03_29_134928_add_payment_method_to_subscriptions_table', 2),
(11, '2026_03_29_144128_create_meal_selections_table', 3),
(12, '2026_03_29_145625_modify_menu_items_table_fields', 4);

-- plans
INSERT INTO "plans" ("id", "name", "description", "price_per_week", "meals_per_week", "features", "is_active", "created_at", "updated_at") VALUES
(1, 'basic', 'Paket Basic - Menu vegetarian dengan kalori terkontrol', 150000.00, 5, '["5 makanan per minggu", "Menu vegetarian", "Kalori terkontrol (1200-1500)", "Pengiriman 2x seminggu", "Konsultasi gizi dasar"]', true, '2026-03-29 05:56:40', '2026-03-29 05:56:40'),
(2, 'premium', 'Paket Premium - Menu variatif dengan konsultasi personal', 250000.00, 10, '["10 makanan per minggu", "Menu variatif (vegan, keto, dll)", "Kalori disesuaikan kebutuhan", "Pengiriman setiap hari", "Konsultasi gizi personal", "Tracking progress"]', true, '2026-03-29 05:56:40', '2026-03-29 05:56:40'),
(3, 'family', 'Paket Family - Menu untuk keluarga dengan 4 porsi', 400000.00, 20, '["20 makanan per minggu", "Menu untuk 4 orang", "Pilihan menu anak-anak", "Pengiriman setiap hari", "Konsultasi gizi keluarga", "Meal planning assistance"]', true, '2026-03-29 05:56:40', '2026-03-29 05:56:40');

-- users
INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "phone", "address", "role", "dietary_preferences", "allergies", "goals", "remember_token", "created_at", "updated_at") VALUES
(1, 'Administrator', 'admin@nutribox.id', NULL, '$2y$12$dc2WBcSG8jQCSy/MLH8ieOGQTJMH3cb62NJZVZLP0y0j/eDxzrFda', '085156942737', NULL, 'admin', 'none', NULL, 'general-health', NULL, '2026-03-29 05:56:39', '2026-03-29 05:56:39'),
(2, 'Dika Pengguna', 'dika@nutribox.id', NULL, '$2y$12$M8NmyIpOpu3Q6kfZtfOasu6huab5NjPnncg8JRWyKkHOxzLQjpQGC', '081234567890', NULL, 'user', 'vegetarian', NULL, 'weight-loss', NULL, '2026-03-29 05:56:40', '2026-03-29 05:56:40'),
(3, 'kya ndut', 'kyandut@gmail.com', NULL, '$2y$12$CzMNvRHQx5S/AeseKCYiCOHjSR4drUsplJM5P8Tz.0t402I7E5aAC', '087864821852', 'jln antena jakarta selatan', 'user', 'keto', NULL, 'weight-loss', 'mfLpCf9zhDWaKky7XwPWqheBsUFXYMIr2T0pATt32vpIGpJclIuHtYTyAB01', '2026-03-29 06:12:45', '2026-03-29 06:41:32'),
(4, 'Budi Santoso', 'courier1@nutribox.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '081234567890', NULL, 'user', 'none', NULL, 'general-health', NULL, '2026-03-29 06:48:21', '2026-03-29 06:48:21'),
(5, 'Sari Dewi', 'courier2@nutribox.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '081234567891', NULL, 'user', 'none', NULL, 'general-health', NULL, '2026-03-29 06:48:21', '2026-03-29 06:48:21'),
(6, 'John Doe', 'customer@example.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '081234567892', 'Jl. Contoh No. 123, Jakarta', 'user', 'none', NULL, 'general-health', NULL, '2026-03-29 06:48:21', '2026-03-29 06:48:21'),
(7, 'nasdang', 'nasdang@nutribox.id', NULL, '$2y$12$1DNMy6wyukWcVUsqgy79BupcXapIxfI3ZiMQ5NUYOKwmC0ycZrFAi', '081316676281', 'dadap', 'user', 'none', NULL, 'general-health', NULL, '2026-03-29 06:48:21', '2026-03-29 06:48:21'),
(8, 'nasdang', 'nasdang12@nutribox.id', NULL, '$2y$10$1Rss3DvkUO.tYdAhJcB.de0ICZF/ZxZ0qjfsTzH6Zs08WKKQXmzZ2', '4234253467', 'kukusan', 'user', 'none', NULL, 'general-health', NULL, '2026-03-29 06:48:21', '2026-03-29 06:48:21'),
(9, 'Administrator', 'admin@nutribox.com', NULL, '$2y$10$tGVin0a9iB54hSWDdti4wu2dnOd8/Rv5Fx5rrBBgzoW6CEWDKUTu.', NULL, NULL, 'admin', 'none', NULL, 'general-health', NULL, '2026-03-29 06:48:21', '2026-03-29 06:48:21'),
(10, 'Kurir Nutribox', 'courier@nutribox.com', NULL, '$2y$10$0zUsRyQ5pQapS2agxmdgzugpTFJbIWCEMJmNxr8D5Qj6TlwcfIA7O', NULL, NULL, 'user', 'none', NULL, 'general-health', NULL, '2026-03-29 06:48:21', '2026-03-29 06:48:21'),
(11, 'Test User', 'test@example.com', NULL, '$2y$12$H80fcfTdU3AVPKQWSLjQtO/1jDY8OxqqIdPoKQHcUU01gUVGXLSiS', '081234567890', 'Jl. Sudirman No. 1, Jakarta Selatan', 'user', 'none', NULL, 'general-health', NULL, '2026-03-29 07:13:48', '2026-03-29 07:23:55');

-- subscriptions
INSERT INTO "subscriptions" ("id", "user_id", "plan_id", "start_date", "duration_weeks", "total_price", "payment_method", "status", "delivery_address", "notes", "created_at", "updated_at") VALUES
(1, 3, 1, '2026-03-30', 1, 150000.00, NULL, 'paused', 'jln antena jakarta selatan', 'test', '2026-03-29 06:14:25', '2026-03-29 06:40:57'),
(2, 3, 3, '2026-03-30', 1, 400000.00, NULL, 'paused', 'jln antena jakarta selatan', NULL, '2026-03-29 06:41:32', '2026-03-29 07:32:16'),
(3, 11, 2, '2026-04-01', 4, 1000000.00, NULL, 'active', 'Jl. Sudirman No. 1, Jakarta Selatan', NULL, '2026-03-29 07:23:55', '2026-03-29 07:23:55'),
(4, 3, 1, '2026-03-30', 4, 600000.00, NULL, 'active', 'jln antena jakarta selatan', NULL, '2026-03-29 07:32:30', '2026-03-29 07:32:30');

-- sessions
INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES
('JvbI9YDKUYeDeYR8JkRM5BNo5GAIKIs3LYEpZEhn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI4Q3BjZUp4WlJPYnJhVmt6d0lXVnJLdDJzSnU1RGw0bGVHcjQ3ZjFqIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjEyMzQ1XC9hZG1pblwvbWVudSIsInJvdXRlIjoiYWRtaW4ubWVudS5pbmRleCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1774797959),
('thr4XPJupJEJrRn7ksFS0I80zPeBH3vBtb5kAdg4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJBYTZDZXNnaEhSVkluMTNGbnNBcFZLcnFhM1FZSndoWVVaNkkzQmtQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMToxMjM0NVwvbWVudSIsInJvdXRlIjoibWVudSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1774809844),
('TKDKdGuefCR1ATu3TKSkBDmAaZgT5BbNZklVcfLL', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJKaVFFS3JIUUFkbFUxdUVQbXBUVU1lRnZIaFZlbkhlZ3dyRGt3dEUxIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjEyMzQ1XC9tZW51Iiwicm91dGUiOiJtZW51In0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1774800799);

-- 3. Reset Sequences (Crucial for BIGSERIAL/SERIAL after manual ID inserts)

SELECT setval('contact_messages_id_seq', (SELECT COALESCE(MAX(id), 1) FROM contact_messages));
SELECT setval('failed_jobs_id_seq', (SELECT COALESCE(MAX(id), 1) FROM failed_jobs));
SELECT setval('jobs_id_seq', (SELECT COALESCE(MAX(id), 1) FROM jobs));
SELECT setval('menu_items_id_seq', (SELECT COALESCE(MAX(id), 1) FROM menu_items));
SELECT setval('migrations_id_seq', (SELECT COALESCE(MAX(id), 1) FROM migrations));
SELECT setval('plans_id_seq', (SELECT COALESCE(MAX(id), 1) FROM plans));
SELECT setval('users_id_seq', (SELECT COALESCE(MAX(id), 1) FROM users));
SELECT setval('subscriptions_id_seq', (SELECT COALESCE(MAX(id), 1) FROM subscriptions));
SELECT setval('meal_selections_id_seq', (SELECT COALESCE(MAX(id), 1) FROM meal_selections));
SELECT setval('orders_id_seq', (SELECT COALESCE(MAX(id), 1) FROM orders));
SELECT setval('weekly_menus_id_seq', (SELECT COALESCE(MAX(id), 1) FROM weekly_menus));
