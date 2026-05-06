<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

#[Group('CategoryApi', weight: 2)]
class CategoryController extends Controller
{
    #[Endpoint(operationId: 'categoryApi.index', title: 'Display a listing of the resource')]
    public function index(): JsonResponse
    {
        try {
            $categories = Category::withCount('products')->orderBy('name')->get();

            return response()->json([
                'message' => 'Categories retrieved successfully',
                'data' => $categories,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'categoryApi.store', title: 'Store a newly created resource in storage')]
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $category = Category::create($request->validated());

            Log::info('Menambah data category', [
                'category_id' => $category->id,
            ]);

            return response()->json([
                'message' => 'Category berhasil ditambahkan',
                'data' => $category,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'categoryApi.show', title: 'Display the specified resource')]
    public function show(int $id): JsonResponse
    {
        try {
            $category = Category::withCount('products')->find($id);

            if (! $category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Category retrieved successfully',
                'data' => $category,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'categoryApi.update', title: 'Update the specified resource in storage')]
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $category->update($request->validated());

            Log::info('Mengubah data category', [
                'category_id' => $category->id,
            ]);

            return response()->json([
                'message' => 'Category berhasil diperbarui',
                'data' => $category,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat mengubah category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    #[Endpoint(operationId: 'categoryApi.destroy', title: 'Remove the specified resource from storage')]
    public function destroy(int $id): JsonResponse|Response
    {
        try {
            $category = Category::find($id);

            if (! $category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $category->delete();

            Log::info('Menghapus data category', [
                'category_id' => $id,
            ]);

            return response()->noContent();
        } catch (\Throwable $e) {
            Log::error('Error saat menghapus category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }
}
