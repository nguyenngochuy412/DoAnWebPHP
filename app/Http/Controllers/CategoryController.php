<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $category = Category::create($validated);

        return redirect()->route('home')
            ->with('success', 'Danh mục đã được tạo thành công.');
    }

    public function show(Category $category)
    {
        $category->load('pets');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $category->update($validated);

        return redirect()->route('home', $category)
            ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    public function destroy(Category $category)
    {
        // Kiểm tra xem category có pets không
        if ($category->pets()->count() > 0) {
            return redirect()->route('home')
                ->with('error', 'Không thể xóa danh mục vì có thú cưng thuộc danh mục này.');
        }

        $category->delete();

        return redirect()->route('home')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }
}