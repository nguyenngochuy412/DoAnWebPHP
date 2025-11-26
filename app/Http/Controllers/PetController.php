<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::where('is_active', true)->where('stock', '>', 0);

        // Lọc theo category
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Lọc theo giống
        if ($request->has('breed')) {
            $query->where('breed', 'like', '%' . $request->breed . '%');
        }

        // Lọc theo giá
        if ($request->has('price_range')) {
            switch ($request->price_range) {
                case 'under_5m':
                    $query->where('price', '<', 5000000);
                    break;
                case '5m_10m':
                    $query->whereBetween('price', [5000000, 10000000]);
                    break;
                case '10m_20m':
                    $query->whereBetween('price', [10000000, 20000000]);
                    break;
                case 'over_20m':
                    $query->where('price', '>', 20000000);
                    break;
            }
        }

        // Sắp xếp
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            default:
                $query->latest();
        }

        $pets = $query->with('images')->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('pets.index', compact('pets', 'categories'));
    }

    public function show($slug)
    {
        $pet = Pet::where('slug', $slug)
            ->where('is_active', true)
            ->with(['images', 'category'])
            ->firstOrFail();

        $relatedPets = Pet::where('category_id', $pet->category_id)
            ->where('id', '!=', $pet->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('images')
            ->take(4)
            ->get();

        return view('pets.show', compact('pet', 'relatedPets'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $pets = Pet::where('is_active', true)
            ->where('stock', '>', 0)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('breed', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->with('images')
            ->paginate(12);

        return view('pets.search', compact('pets', 'query'));
    }
}
