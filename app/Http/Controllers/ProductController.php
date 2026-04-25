<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $products = Product::with(['category', 'user'])->latest()->get();

        return view('product.index', compact('products'));
    }

    public function export()
    {
        // Dummy export logic
        return response('File export is ready for user '.auth()->user()->name, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        try {
            Product::create($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');
        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating product.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('product.create', compact('categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'user'])->findOrFail($id);

        return view('product.view', compact('product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->authorize('update', $product);

        $validated = $request->validated();

        $product->update($validated);

        return redirect()
            ->route('product.index')
            ->with('success', 'Product updated successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::orderBy('name')->get();

        return view('product.edit', compact('product', 'categories'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}
