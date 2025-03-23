# Changelog

## 2023-06-15

### Added
- Maintenance Mode Feature
  - Added `maintenance_mode` boolean field to Settings table
  - Created MaintenanceController with index and preview methods
  - Implemented CheckMaintenanceMode middleware to handle redirects
  - Added maintenance page views with responsive design and animations
  - Updated routes configuration to properly handle maintenance mode
  - Added toggle functionality in admin settings for maintenance mode

- First-time Setup Automation
  - Created dedicated AdminSeeder that checks if admin exists before creating
  - Updated DatabaseSeeder to use the new AdminSeeder
  - Added setup.php script for easy first-time installation
  - Implemented comprehensive README with installation instructions

### Updated
- Controllers
  - Modified SettingController to handle maintenance mode toggle
  - Improved route organization with proper middleware application
  - Fixed maintenance mode caching for better performance

### Frontend
- Created maintenance page with:
  - Animated elements (floating particles, pulsing icon)
  - Word cycling animation with fade effects
  - Responsive design for all device sizes
  - Social media links from site settings
  - Elnakieb attribution in footer

## Features in Progress
- User Profile Management
  - Password changing functionality 