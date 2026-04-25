<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()
            ->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        return redirect()
            ->route('category.index')
            ->with('success', 'Category updated successfully.');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()
            ->route('category.index')
            ->with('success', 'Category deleted successfully.');
    }
}
