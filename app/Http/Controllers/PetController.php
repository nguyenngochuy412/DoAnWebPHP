<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pet;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SebastianBergmann\Environment\Console;

class PetController extends Controller
{
    /* ======================== FRONTEND ======================== */

    public function index(Request $request)
    {
        $search = $request->input('keyword');
        if($search){
            $query = Pet::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orwhere('color', 'like', '%'. $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        } else {
            $query = Pet::where('is_active', true);
        }

        // // Lọc category
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // // Lọc giá
        if (!empty($request->input('min_price'))) {
            $query->where('price', '>=', $request->min_price);
            if(!empty($request->input('max_price'))){
                $query->whereBetween('price', [$request->min_price, $request->max_price]);
            }
        } elseif (!empty($request->input('max_price'))) {
            $query->where('price', '<=', $request->max_price);
        }

        if(!empty($request->input('gender'))) {
            $query->where('gender', $request->gender);
        }

        if(!empty($request->input('vaccination_status'))) {
            $query->where('vaccination_status', $request->vaccination_status);
        }

        $pets = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('admin.pets.index', compact('pets', 'categories'));
    }

    public function show($id)
    {
        $pet = Pet::where('id', $id)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $relatedPets = Pet::where('category_id', $pet->category_id)
            ->where('id', '!=', $pet->id)
            ->where('is_active', true)
            ->get();

        return view('admin.pets.show', compact('pet', 'relatedPets'));
    }

    /* ======================== ADMIN CRUD ======================== */

    public function create()
    {
        $categories = Category::all();
        return view('admin.pets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'color' => 'required|string|max:100',
            'weight' => 'required|numeric|min:0',
            'vaccination_status' => 'required|in:fully,partial,none',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Tạo slug từ name
        $validated['slug'] = Str::slug($validated['name']);

        // Xử lý upload ảnh
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $request->file('image')->store('pets', 'public');
            $validated['image'] = $path;
        } else {
            // Đảm bảo image là null nếu không có file upload
            $validated['image'] = null;
        }

        $pet = Pet::create($validated + [
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('pets.index')
            ->with('success', 'Thú cưng đã được thêm thành công.');
    }

    public function edit(Pet $pet)
    {
        $categories = Category::all();
        return view('admin.pets.edit', compact('pet', 'categories'));
    }

    public function update(Request $request, Pet $pet)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'color' => 'required|string|max:100',
            'weight' => 'required|numeric|min:0',
            'vaccination_status' => 'required|in:fully,partial,none',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Cập nhật slug nếu name thay đổi
        if ($validated['name'] !== $pet->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Xử lý upload ảnh mới
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Xóa ảnh cũ nếu có
            if ($pet->image) {
                Storage::disk('public')->delete($pet->image);
            }
            $path = $request->file('image')->store('pets', 'public');
            $validated['image'] = $path;
        } else {
            // Giữ nguyên ảnh cũ nếu không upload ảnh mới và không yêu cầu xóa
            if (!$request->has('remove_image')) {
                $validated['image'] = $pet->image;
            }
        }

        $pet->update($validated + [
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('pets.index')
            ->with('success', 'Thú cưng đã được cập nhật thành công.');
    }

    public function destroy(Pet $pet)
    {
        // Xóa ảnh nếu có
        if ($pet->image) {
            Storage::disk('public')->delete($pet->image);
        }

        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Thú cưng đã được xóa thành công.');
    }
}
