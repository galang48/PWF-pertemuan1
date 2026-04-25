<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }

        if (! Schema::hasColumn('categories', 'name')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('name')->unique()->after('id');
            });
        } elseif (! $this->hasIndex('categories', 'categories_name_unique')) {
            $this->deduplicateCategoryNames();

            Schema::table('categories', function (Blueprint $table) {
                $table->unique('name');
            });
        }

        if (Schema::hasColumn('categories', 'product_id')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }

        if (Schema::hasTable('products') && ! Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('categories')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }

        if (Schema::hasTable('categories') && ! Schema::hasColumn('categories', 'product_id')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->foreignId('product_id')
                    ->nullable()
                    ->constrained('products')
                    ->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('categories') && $this->hasIndex('categories', 'categories_name_unique')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropUnique('categories_name_unique');
            });
        }
    }

    private function deduplicateCategoryNames(): void
    {
        $duplicates = DB::table('categories')
            ->select('name', DB::raw('COUNT(*) as total'))
            ->groupBy('name')
            ->having('total', '>', 1)
            ->pluck('name');

        foreach ($duplicates as $name) {
            $categories = DB::table('categories')
                ->where('name', $name)
                ->orderBy('id')
                ->get()
                ->skip(1);

            foreach ($categories as $category) {
                DB::table('categories')
                    ->where('id', $category->id)
                    ->update(['name' => "{$name} {$category->id}"]);
            }
        }
    }

    private function hasIndex(string $table, string $index): bool
    {
        return collect(Schema::getIndexes($table))
            ->contains(fn (array $item) => ($item['name'] ?? null) === $index);
    }
};
