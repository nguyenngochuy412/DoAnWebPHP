<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy thú cưng nổi bật
        $featuredPets = Pet::where('is_featured', true)
            ->where('is_active', true)
            ->get();
        
        // Lấy danh mục
        $categories = Category::where('is_active', true)
            ->withCount(['pets' => function($query) {
                $query->where('is_active', true);
            }])
            ->get();
        
        return view('layouts.home', compact('featuredPets', 'categories'));
    }
}