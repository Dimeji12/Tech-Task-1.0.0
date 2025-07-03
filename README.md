 🚀 Installation Instructions

Follow these steps to get the application running locally.

---

## 🔧 Prerequisites

- Docker & Docker Compose installed (for Laravel Sail)  
- Composer installed (optional if you run Sail directly)

---

## ⚙️ Setup Steps

1. **Copy the environment config**  
```bash
cp .env.example .env


2. Install PHP dependencies
composer install


3.Start Laravel Sail (Docker containers)
./vendor/bin/sail up
🐋 This starts the Docker containers in the background.


4.Open a new terminal tab/window, then run:

-Migrate the database:
./vendor/bin/sail artisan migrate

-Seed the database:
./vendor/bin/sail artisan db:seed

-Install frontend dependencies:
npm install



5.npm run watch



