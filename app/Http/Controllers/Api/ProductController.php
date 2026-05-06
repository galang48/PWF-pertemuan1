<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

#[Group('ProductApi', weight: 3)]
class ProductController extends Controller
{
    #[Endpoint(operationId: 'productApi.index', title: 'Display a listing of the resource')]
    public function index(): JsonResponse
    {
        try {
            $products = Product::with('category')->latest()->get();

            return response()->json([
                'message' => 'Products retrieved successfully',
                'data' => $products,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'productApi.store', title: 'Store a newly created resource in storage')]
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = $request->user()->id;

            $product = Product::create($validated)->load('category');

            Log::info('Menambah data produk', [
                'product_id' => $product->id,
            ]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'productApi.show', title: 'Display the specified resource')]
    public function show(int $id): JsonResponse
    {
        try {
            $product = Product::with('category')->find($id);

            if (! $product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $product,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'productApi.update', title: 'Update the specified resource in storage')]
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $product = Product::find($id);

            if (! $product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            if (! $this->canModifyProduct($request, $product)) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses ke produk ini',
                ], 403);
            }

            $product->update($request->validated());
            $product->load('category');

            Log::info('Mengubah data produk', [
                'product_id' => $product->id,
            ]);

            return response()->json([
                'message' => 'Produk berhasil diperbarui',
                'data' => $product,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat mengubah product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'productApi.destroy', title: 'Remove the specified resource from storage')]
    public function destroy(Request $request, int $id): JsonResponse|Response
    {
        try {
            $product = Product::find($id);

            if (! $product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            if (! $this->canModifyProduct($request, $product)) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses ke produk ini',
                ], 403);
            }

            $product->delete();

            Log::info('Menghapus data produk', [
                'product_id' => $id,
            ]);

            return response()->noContent();
        } catch (\Throwable $e) {
            Log::error('Error saat menghapus product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    private function canModifyProduct(Request $request, Product $product): bool
    {
        $user = $request->user();

        return $user && ($user->role === 'admin' || $user->id === $product->user_id);
    }
}
