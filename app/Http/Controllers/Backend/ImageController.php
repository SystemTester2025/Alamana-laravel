<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of all images from public directory
     */
    public function index()
    {
        // Get images from database
        $dbImages = Image::all()->map(function($image) {
            return [
                'name' => basename($image->path),
                'url' => $image->url ?? asset($image->path),
                'full_url' => $image->url ?? asset($image->path),
                'size' => file_exists(public_path($image->path)) ? $this->formatSize(filesize(public_path($image->path))) : 'Unknown',
                'path' => $image->path,
                'extension' => pathinfo($image->path, PATHINFO_EXTENSION),
                'id' => $image->id
            ];
        })->toArray();
        
        // Get images from filesystem
        $fsImages = $this->scanImagesFromPublic();
        
        // Merge both arrays, removing duplicates by URL
        $urlMap = [];
        $images = [];
        
        foreach ($dbImages as $image) {
            $urlMap[basename($image['path'])] = true;
            $images[] = $image;
        }
        
        foreach ($fsImages as $image) {
            if (!isset($urlMap[basename($image['path'] ?? $image['url'])])) {
                $images[] = $image;
                $urlMap[basename($image['path'] ?? $image['url'])] = true;
            }
        }
        
        return view('backend.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('images.index');
    }

    /**
     * Store a newly created image in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string|max:255',
            'alt' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in the public/images directory
            $path = $file->storeAs('images', $fileName, 'public');
            
            // Get the URL for the image with current host and port
            $url = request()->getSchemeAndHttpHost() . '/storage/' . $path;
            
            // Create a record in the images table
            Image::create([
                'title' => $request->title ?? $file->getClientOriginalName(),
                'path' => $path,
                'url' => $url,
                'alt' => $request->alt ?? $request->title ?? $file->getClientOriginalName(),
                'type' => 'general',
            ]);

            return redirect()->route('images.index')->with('success', 'تم رفع الصورة بنجاح');
        }

        return redirect()->route('images.index')->with('error', 'حدث خطأ أثناء رفع الصورة');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('images.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect()->route('images.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('images.index');
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroy(string $id)
    {
        // Check if $id is numeric (database ID) or a string (filename)
        if (is_numeric($id)) {
            // ID-based deletion
            $image = Image::find($id);
            
            if ($image) {
                // Delete the file if it exists
                $filePath = public_path($image->path);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                
                // Delete from database
                $image->delete();
                
                return redirect()->route('images.index')->with('success', 'تم حذف الصورة بنجاح');
            }
        } else {
            // Filename-based deletion
            // Find all possible paths where the file might be located
            $possiblePaths = [
                public_path('storage/images/' . $id),
                public_path('storage/products/' . $id),
                public_path('storage/settings/' . $id),
                public_path('storage/' . $id),
                public_path('images/' . $id),
                public_path($id),
            ];
            
            $deleted = false;
            
            foreach ($possiblePaths as $path) {
                if (File::exists($path)) {
                    File::delete($path);
                    $deleted = true;
                    break;
                }
            }
            
            // Also delete from the database if it exists
            $image = Image::where('path', 'LIKE', '%' . $id . '%')->first();
            if ($image) {
                $image->delete();
                $deleted = true;
            }
            
            if ($deleted) {
                return redirect()->route('images.index')->with('success', 'تم حذف الصورة بنجاح');
            }
        }
        
        return redirect()->route('images.index')->with('error', 'لم يتم العثور على الصورة');
    }
    
    /**
     * Scan all images from public directory and subdirectories
     *
     * @return array
     */
    private function scanImagesFromPublic()
    {
        $images = [];
        $publicPath = public_path();
        
        // Define the image extensions to look for
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
        
        // Define directories to scan
        $directoriesToScan = [
            $publicPath,
            public_path('images'),
            public_path('storage'),
            public_path('storage/images'),
            public_path('storage/products'),
            public_path('storage/settings'),
        ];
        
        foreach ($directoriesToScan as $directory) {
            if (File::isDirectory($directory)) {
                $this->scanDirectory($directory, $publicPath, $imageExtensions, $images);
            }
        }
        
        // Sort images by name
        usort($images, function($a, $b) {
            return $a['name'] <=> $b['name'];
        });
        
        return $images;
    }
    
    /**
     * Recursively scan a directory for images
     *
     * @param string $directory
     * @param string $publicPath
     * @param array $imageExtensions
     * @param array &$images
     * @return void
     */
    private function scanDirectory($directory, $publicPath, $imageExtensions, &$images)
    {
        $files = File::files($directory);
        
        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            
            if (in_array($extension, $imageExtensions)) {
                // Convert the absolute path to a relative URL
                $relativePath = str_replace('\\', '/', str_replace($publicPath, '', $file->getPathname()));
                $relativePath = ltrim($relativePath, '/');
                
                // Generate full URL with current host and port
                $fullUrl = request()->getSchemeAndHttpHost() . '/' . $relativePath;
                
                $images[] = [
                    'name' => $file->getFilename(),
                    'url' => $relativePath,
                    'full_url' => $fullUrl,
                    'size' => $this->formatSize($file->getSize()),
                    'path' => $file->getPathname(),
                    'extension' => $extension,
                ];
            }
        }
        
        // Process subdirectories
        $directories = File::directories($directory);
        
        foreach ($directories as $subDirectory) {
            // Skip node_modules and vendor directories
            if (strpos($subDirectory, 'node_modules') !== false || 
                strpos($subDirectory, 'vendor') !== false) {
                continue;
            }
            
            $this->scanDirectory($subDirectory, $publicPath, $imageExtensions, $images);
        }
    }
    
    /**
     * Format file size for display
     *
     * @param int $bytes
     * @return string
     */
    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
