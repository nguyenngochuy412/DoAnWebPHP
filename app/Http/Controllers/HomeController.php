<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPets = Pet::where('is_featured', true)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('images')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)->get();

        return view('home', compact('featuredPets', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
