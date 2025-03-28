<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured products and sections
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get featured products first, then other products limited to 6 total
        $featuredProducts = Product::featured()->ordered()->get();
        
        $remainingCount = 6 - $featuredProducts->count();
        $otherProducts = collect();
        
        if ($remainingCount > 0) {
            $otherProducts = Product::where('featured', false)
                ->ordered()
                ->limit($remainingCount)
                ->get();
        }
        
        $products = $featuredProducts->concat($otherProducts);
        
        // Get all sections with their section parts
        $sections = Section::with(['sectionParts' => function($query) {
            $query->orderBy('sort_order', 'asc');
        }])->get();
        
        // Convert sections to a keyed collection for easier access in views
        $sectionsKeyed = $sections->keyBy('slug');
        // Check if site is in maintenance mode and redirect if needed
        // This is a fallback in case the middleware doesn't catch it
        $settings = Setting::first();
        // if ($settings && $settings->maintenance_mode) {
        //     return redirect()->route('maintenance');
        // }
        // else{
            return view('frontend.home', compact('products', 'sections', 'sectionsKeyed'));
        // }

        
        
    }
} 