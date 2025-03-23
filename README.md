# Alamana Website

## Installation

Follow these steps to install and set up the Alamana website:

### Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL or MariaDB
- Node.js and NPM

### Installation Steps

1. Clone the repository:
   ```
   git clone https://github.com/your-username/alamana-website.git
   cd alamana-website
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Run the setup script:
   ```
   php setup.php
   ```
   This script will:
   - Create a .env file from .env.example
   - Generate application key
   - Guide you through database setup
   - Run migrations and seeders
   - Create storage link
   - Clear application caches

5. Build assets:
   ```
   npm run dev
   ```

6. Start the development server:
   ```
   php artisan serve
   ```

### Default Admin Credentials

After installation, you can log in with the following credentials:
- Email: admin@admin.com
- Password: admin

**Important:** Please change these credentials after your first login for security purposes.

## Features

- Responsive Design
- Admin Dashboard
- Product Management
- Media Management
- User Management
- Maintenance Mode
- Contact Form

## Maintenance Mode

The site includes a maintenance mode feature that redirects all visitors to a maintenance page when enabled. To enable/disable maintenance mode:

1. Log in to the admin dashboard
2. Go to Settings
3. Toggle the Maintenance Mode switch
4. Save changes

Only admin users can access the site when maintenance mode is activated.

## License

This project is proprietary and confidential. Unauthorized copying, modification, distribution, or use of any part of this software is strictly prohibited.
 
