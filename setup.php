<?php

/**
 * First-time setup script for the application
 * This script guides the user through the initial setup process.
 */

// Check if .env file exists
if (!file_exists('.env')) {
    echo "Creating .env file from .env.example...\n";
    copy('.env.example', '.env');
    echo "✅ .env file created successfully!\n\n";
} else {
    echo "⏩ .env file already exists. Skipping creation.\n\n";
}

// Generate application key
echo "Generating application key...\n";
passthru('php artisan key:generate');
echo "✅ Application key generated successfully!\n\n";

// Ask user if they want to set up the database
echo "Would you like to set up the database now? (yes/no): ";
$setupDatabase = trim(fgets(STDIN));

if (strtolower($setupDatabase) === 'yes' || strtolower($setupDatabase) === 'y') {
    // Run migrations and seeders
    echo "Running database migrations...\n";
    passthru('php artisan migrate');
    echo "✅ Database migrations completed!\n\n";
    
    echo "Running database seeders...\n";
    passthru('php artisan db:seed');
    echo "✅ Database seeding completed!\n\n";
    
    echo "Creating symbolic link for storage...\n";
    passthru('php artisan storage:link');
    echo "✅ Storage link created!\n\n";
} else {
    echo "⏩ Database setup skipped. You can run the following commands manually later:\n";
    echo "   - php artisan migrate\n";
    echo "   - php artisan db:seed\n";
    echo "   - php artisan storage:link\n\n";
}

// Clear caches
echo "Clearing application cache...\n";
passthru('php artisan cache:clear');
passthru('php artisan config:clear');
passthru('php artisan view:clear');
passthru('php artisan route:clear');
echo "✅ Application cache cleared!\n\n";

// Complete setup
echo "🎉 Setup completed successfully! 🎉\n";
echo "✅ Default admin credentials:\n";
echo "   - Email: admin@admin.com\n";
echo "   - Password: admin\n";
echo "   ⚠️ Please change these credentials after your first login!\n\n";
echo "To start the development server, run: php artisan serve\n"; 