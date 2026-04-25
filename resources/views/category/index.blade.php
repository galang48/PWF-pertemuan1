<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-100 tracking-tight">
                                Category List
                            </h2>
                            <p class="text-sm text-gray-400 mt-1">Manage your category</p>
                        </div>

                        <x-add-product :url="route('category.create')" name="Category" />
                    </div>

                    @if (session('success'))
                        <div
                            class="mb-4 px-4 py-3 bg-green-900/30 border border-green-700 text-green-300 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full table-auto divide-y divide-gray-700 text-sm">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider w-8">
                                        1</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                        Total Product</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse ($categories as $category)
                                    <tr class="hover:bg-gray-700/50 transition duration-100">
                                        <td class="px-6 py-4 text-gray-400">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-4 font-medium text-gray-400">
                                            {{ $category->name }}
                                        </td>

                                        <td class="px-6 py-4 text-gray-400">
                                            {{ $category->products_count }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <x-edit-product :url="route('category.edit', $category)" name="Category" icon-only />
                                                <x-delete-product :url="route('category.delete', $category->id)" name="Category"
                                                    :message="'Delete this category and its related products?'" icon-only />
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
