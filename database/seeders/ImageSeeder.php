<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing images from table
        Image::truncate();
        
        $publicPath = public_path();
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
        
        // Define directories to scan
        $directoriesToScan = [
            public_path('images'),
            public_path('storage/images'),
            public_path('storage/products'),
            public_path('storage/settings'),
        ];
        
        foreach ($directoriesToScan as $directory) {
            if (File::isDirectory($directory)) {
                $this->scanAndSeedDirectory($directory, $publicPath, $imageExtensions);
            }
        }
    }
    
    /**
     * Recursively scan a directory and seed images
     */
    private function scanAndSeedDirectory($directory, $publicPath, $imageExtensions)
    {
        $files = File::files($directory);
        
        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            
            if (in_array($extension, $imageExtensions)) {
                // Convert the absolute path to a relative URL
                $relativePath = str_replace('\\', '/', str_replace($publicPath, '', $file->getPathname()));
                $relativePath = ltrim($relativePath, '/');
                
                // Generate a full URL with proper host and port
                $url = request()->getSchemeAndHttpHost() . '/' . $relativePath;
                
                // Create the image record
                Image::create([
                    'title' => $file->getFilename(),
                    'path' => $relativePath,
                    'url' => $url,
                    'alt' => $file->getFilename(),
                    'type' => $this->determineImageType($relativePath),
                    'sort_order' => 0,
                ]);
            }
        }
        
        // Process subdirectories
        $directories = File::directories($directory);
        
        foreach ($directories as $subDirectory) {
            $this->scanAndSeedDirectory($subDirectory, $publicPath, $imageExtensions);
        }
    }
    
    /**
     * Determine the image type based on its path
     */
    private function determineImageType($path)
    {
        if (strpos($path, 'products') !== false) {
            return 'product';
        } elseif (strpos($path, 'hero-section') !== false) {
            return 'hero';
        } elseif (strpos($path, 'settings') !== false) {
            return 'setting';
        } else {
            return 'general';
        }
    }
} 