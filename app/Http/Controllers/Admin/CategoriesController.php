<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount(['courses' => function($q) {
            $q->where('is_active', true); // For active course count
        }])->withCount('courses as total_courses_count'); // For total course count
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by active status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Sort options
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name');
                break;
            case 'name_desc':
                $query->orderByDesc('name');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $categories = $query->paginate(9);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'fa-folder',
            'description' => $request->description,
            'color' => $request->color ?? '#3B82F6',
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon,
            'description' => $request->description,
            'color' => $request->color,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing courses.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}