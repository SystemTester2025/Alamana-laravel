<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured products
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
        
        return view('frontend.home', compact('products'));
    }
} 