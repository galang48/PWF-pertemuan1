<x-app-layout>
    <style>
        .pd-shell {
            max-width: 980px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .pd-card {
            background: #202938;
            border: 1px solid rgba(148, 163, 184, 0.14);
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(2, 6, 23, 0.35);
            overflow: hidden;
        }

        .pd-inner {
            padding: 36px 44px;
        }

        .pd-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .pd-header-left {
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .pd-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            margin-top: 3px;
            border-radius: 999px;
            color: #94a3b8;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .pd-back:hover {
            background: rgba(148, 163, 184, 0.08);
            color: #e2e8f0;
        }

        .pd-title {
            margin: 0;
            font-size: 34px;
            line-height: 1.15;
            font-weight: 700;
            color: #f8fafc;
        }

        .pd-subtitle {
            margin: 10px 0 0;
            font-size: 16px;
            color: #94a3b8;
        }

        .pd-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .pd-section {
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 18px;
            overflow: hidden;
            background: rgba(15, 23, 42, 0.15);
        }

        .pd-row {
            display: grid;
            grid-template-columns: 190px minmax(0, 1fr);
            gap: 18px;
            align-items: center;
            padding: 24px 30px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        }

        .pd-row:last-child {
            border-bottom: none;
        }

        .pd-label {
            font-size: 15px;
            font-weight: 500;
            color: #94a3b8;
        }

        .pd-value {
            font-size: 20px;
            font-weight: 600;
            color: #f8fafc;
        }

        .pd-price {
            letter-spacing: 0.02em;
        }

        .pd-owner {
            display: inline-flex;
            align-items: center;
            gap: 14px;
        }

        .pd-owner-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 999px;
            background: rgba(79, 70, 229, 0.3);
            color: #c7d2fe;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .pd-stock {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 700;
        }

        .pd-stock.in-stock {
            background: rgba(34, 197, 94, 0.14);
            color: #4ade80;
        }

        .pd-stock.low-stock {
            background: rgba(239, 68, 68, 0.14);
            color: #f87171;
        }

        .pd-time {
            font-size: 17px;
            font-weight: 500;
            color: #e2e8f0;
        }

        .pd-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 22px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none;
            background: transparent;
            transition: 0.2s ease;
        }

        .pd-btn svg {
            width: 18px;
            height: 18px;
        }

        .pd-btn-edit {
            border: 1.5px solid rgba(245, 158, 11, 0.8);
            color: #fbbf24;
        }

        .pd-btn-edit:hover {
            background: rgba(245, 158, 11, 0.08);
        }

        .pd-btn-delete {
            border: 1.5px solid rgba(239, 68, 68, 0.85);
            color: #f87171;
        }

        .pd-btn-delete:hover {
            background: rgba(239, 68, 68, 0.08);
        }

        .pd-btn-delete-form {
            margin: 0;
        }

        @media (max-width: 768px) {
            .pd-shell {
                padding: 0 16px;
            }

            .pd-inner {
                padding: 24px 18px;
            }

            .pd-header {
                flex-direction: column;
                align-items: stretch;
            }

            .pd-row {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 18px 18px;
            }

            .pd-title {
                font-size: 28px;
            }

            .pd-actions {
                width: 100%;
            }

            .pd-btn,
            .pd-btn-delete-form {
                width: 100%;
            }

            .pd-btn,
            .pd-btn-delete-form .pd-btn {
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <div class="py-12">
        <div class="pd-shell">
            <div class="pd-card">
                <div class="pd-inner">
                    <div class="pd-header">
                        <div class="pd-header-left">
                            <a href="{{ route('product.index') }}" class="pd-back" aria-label="Back to products">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>

                            <div>
                                <h2 class="pd-title">Product Detail</h2>
                                <p class="pd-subtitle">Viewing product #{{ $product->id }}</p>
                            </div>
                        </div>

                        <div class="pd-actions">
                            @can('update', $product)
                                <a href="{{ route('product.edit', $product) }}" class="pd-btn pd-btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $product)
                                <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                    class="pd-btn-delete-form"
                                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="pd-btn pd-btn-delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4h6v3" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="pd-section">
                        <div class="pd-row">
                            <div class="pd-label">Product Name</div>
                            <div class="pd-value">{{ $product->name }}</div>
                        </div>

                        <div class="pd-row">
                            <div class="pd-label">Quantity</div>
                            <div>
                                <span class="pd-stock {{ $product->quantity > 0 ? 'in-stock' : 'low-stock' }}">
                                    {{ $product->quantity }} {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>

                        <div class="pd-row">
                            <div class="pd-label">Price</div>
                            <div class="pd-value pd-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>

                        <div class="pd-row">
                            <div class="pd-label">Owner</div>
                            <div class="pd-owner">
                                <span class="pd-owner-badge">{{ substr($product->user->name ?? '?', 0, 1) }}</span>
                                <span class="pd-value">{{ $product->user->name ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="pd-row">
                            <div class="pd-label">Created At</div>
                            <div class="pd-time">{{ $product->created_at->format('d M Y, H:i') }}</div>
                        </div>

                        <div class="pd-row">
                            <div class="pd-label">Updated At</div>
                            <div class="pd-time">{{ $product->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
