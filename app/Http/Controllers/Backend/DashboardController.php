<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Image;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'sections' => Section::count(),
            'products' => Product::count(),
            'contacts' => Contact::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
            'images' => Image::count(),
        ];
        
        $latest_contacts = Contact::orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
        
        $latest_products = Product::orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
        
        return view('backend.dashboard', compact('stats', 'latest_contacts', 'latest_products'));
    }
}
