# Sweet Spot Analyse

A modern Laravel web application built with Livewire, Volt, and Tailwind CSS.

## Tech Stack
- **Framework:** [Laravel 12.0](https://laravel.com/)
- **Frontend/UI:** [Livewire 4.2](https://livewire.laravel.com/), Livewire Volt, Alpine.js, Tailwind CSS
- **Database:** SQLite (default) / MySQL / PostgreSQL
- **PHP Version:** 8.2+

## Prerequisites
Before you begin, ensure you have the following tools installed on your system:
- PHP >= 8.2
- Composer
- Node.js & npm
- Git

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/mrshahbazdev/Sweet-Spot.git
   cd Sweet-Spot-Analyse
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   Copy the `.env.example` file to `.env` and generate an application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup:**
   By default, the application uses SQLite. Run the migrations to prepare your database.
   ```bash
   php artisan migrate
   ```

6. **Build Frontend Assets:**
   ```bash
   npm run build
   ```

## Running Locally

To run the application locally, you can use the built-in Composer script, which starts both the Laravel server and Vite concurrently:

```bash
composer run dev
```

The application will be accessible at `http://localhost:8000`.

## Shared Hosting Deployment
For cPanel or standard shared hosting environments, a root `.htaccess` file is included in this repository. When you upload the project files to your main `public_html` directory, this `.htaccess` file automatically forwards all public web traffic to the internal `public/` folder, securing your environment files securely.

## Testing
Run the test suite using Laravel's base PHPUnit / Pest configuration:
```bash
php artisan test
```

## License
The Laravel framework and this project are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
