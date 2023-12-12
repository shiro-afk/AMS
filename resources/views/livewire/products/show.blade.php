<div>
    <!-- Show Modal -->
    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show Item') }} - {{ $product?->code }}
        </x-slot>

        <x-slot name="content">

            <div class="px-4 mx-auto mb-4">
                @if ($product)
                    @if (settings()->telegram_channel)
                        <div class="flex justify-center w-full my-5 px-3">
                            <x-button success type="button" wire:click="$emit('sendTelegram',{{ $product?->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                                {{ __('Send to telegram') }}
                            </x-button>
                        </div>
                    @endif
                    <div class="space-y-2 mb-4">
                        @if ($product->image)
                            <div class="w-full px-3">
                                <img src="{{ asset('images/products/' . $product?->image) }}" alt="{{ $product?->name }}"
                                    class="w-32 h-32 rounded">
                            </div>
                        @endif
                        <div class="flex justify-center w-full px-3 ">
                            <!-- Concatenate Product Code and Name -->
                            @if ($product)
                            @php
                                $combinedData = 'Serial Number: ' . $product->code . "\n" .
                                                'Item Name: ' . $product->name . "\n" .
                                                'Category: ' . $product->category->name . "\n";

                                // Add tax type information
                                $combinedData .= 'Status: ' . ($product->tax_type ?? 'N/A');
                                $combinedData .= "\nSchool: " . (optional($product->brand)->name);
                                $combinedData .= "\nUnits: " . ($product->unit);

                                // Add warehouse information


                                $combinedData .= "\nRemarks: " . ($product->note ?? 'N/A');
                            @endphp

                            <!-- Display QR Code -->
                            {!! QrCode::size(150)->encoding('UTF-8')->generate($combinedData); !!}
                        @endif


                        </div>
                    </div>
                @endif
                <div x-data="{ activeTabs: 'productDetails' }">
                    <div class="grid gap-4 lg:grid-cols-2 sm:grid-cols-2 py-2 bg-gray-100">
                        <div class="text-center font-bold text-gray-500 uppercase mb-2 cursor-pointer"
                            @click="activeTabs = 'productDetails'">
                            <h4 class="inline-block" :class="activeTabs === 'productDetails' ? 'text-red-400' : ''">
                                {{ __('Details') }}
                            </h4>
                        </div>

                    </div>
                    <div x-show="activeTabs === 'productDetails'">
                        <div role="productDetails" aria-labelledby="tab-0" id="tab-panel-0" tabindex="0">
                            <div class="w-full">
                                <x-table-responsive>
                                    <x-table.tr>
                                        <x-table.th>{{ __('Product Code') }}</x-table.th>
                                        <x-table.td class="p-3 text-left text-gray-800">{{ $product?->code }}</x-table.td>
                                    </x-table.tr>
                                    {{--<x-table.tr>
                                        <x-table.th>{{ __('Barcode Symbology') }}</x-table.th>
                                        <x-table.td>{{ $product?->barcode_symbology }}</x-table.td>
                                    </x-table.tr>--}}
                                    <x-table.tr>
                                        <x-table.th>{{ __('Name') }}</x-table.th>
                                        <x-table.td class="p-3 text-left text-gray-800">{{ $product?->name }}</x-table.td>
                                    </x-table.tr>
                                    <x-table.tr>
                                        <x-table.th>{{ __('Category') }}</x-table.th>
                                        <x-table.td class="p-3 text-left text-gray-800">{{ $product?->category->name }}</x-table.td>
                                    </x-table.tr>
                                    <x-table.th>{{ __('School') }}</x-table.th>
                                    <x-table.td class="p-3 text-left text-gray-800">{{ optional($product->brand)->name }}</x-table.td>
                                         {{-- <x-table.td>
                                        <div class="flex flex-wrap">
                                            @if ($product?->warehouses)
                                            @forelse ($product->warehouses as $warehouse)
                                                <div class="mr-4 mb-4">
                                                    <p class="font-medium">{{ $warehouse->name }}</p>
                                                    <p class="text-sm">{{ __('Quantity') }}:
                                                        {{ $warehouse->pivot->qty }} {{ $product->unit }}</p>
                                                  {{--  <p class="text-sm">{{ __('Cost') }}:
                                                        {{ format_currency($warehouse->pivot->cost) }}</p>
                                                    <p class="text-sm">{{ __('Price') }}:
                                                        {{ format_currency($warehouse->pivot->price) }}</p>
                                                {{--    <p class="text-sm">{{ __('Stock Worth') }}:
                                                        {{ format_currency($warehouse->pivot->cost * $warehouse->pivot->qty) }}
                                                    </p>
                                                </div>
                                            @empty
                                                {{ __('No School assigned') }}
                                            @endforelse
                                            @endif
                                        </div>
                                    </x-table.td>
                                    <x-table.tr>
                                        <x-table.th>{{ __('Alert Quantity') }}</x-table.th>
                                        <x-table.td>{{ $product?->stock_alert }}</x-table.td>
                                    </x-table.tr>
                                    <x-table.tr>
                                        <x-table.th>{{ __('Tax (%)') }}</x-table.th>
                                        <x-table.td>{{ $product?->order_tax ?? 'N/A' }}</x-table.td>
                                    </x-table.tr>--}}
                                    <x-table.tr>
                                        <x-table.th>{{ __('Status') }}</x-table.th>
                                        <x-table.td class="p-3 text-left text-gray-800">
                                            {{$product->tax_type ?? 'N/A'}}
                                        </x-table.td>
                                    </x-table.tr>
                                    <x-table.tr>
                                        <x-table.th>{{ __('Units') }}</x-table.th>
                                        <x-table.td class="p-3 text-left text-gray-800">
                                            {{$product->unit?? 'N/A'}}
                                        </x-table.td>
                                    </x-table.tr>
                                    <x-table.tr>
                                        <x-table.th>{{ __('Description') }}</x-table.th>
                                        <x-table.td class="p-3 text-left text-gray-800">{{ $product?->note ?? 'N/A' }}</x-table.td>
                                    </x-table.tr>
                                </x-table-responsive>
                            </div>
                        </div>
                    </div>
                    <div x-show="activeTabs === 'productMovements'">
                        <div role="productMovements" aria-labelledby="tab-0" id="tab-panel-0" tabindex="0">
                            @if ($product)
                                <ul class="space-y-4">
                                    @forelse ($product->movements as $movement)
                                        <li class="border p-4 rounded-md shadow-md">
                                            <div class="flex items-center">
                                                <span class="font-semibold">{{ __('Type') }}:</span>
                                                <span class="ml-2">
                                                    {{ $movement->type->getName() }}
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="font-semibold">{{ __('Quantity') }}:</span>
                                                <span class="ml-2">{{ $movement->quantity }}</span>
                                            </div>
                                            {{-- <div class="flex items-center">
                                                <span class="font-semibold">{{ __('User') }}:</span>
                                                <span class="ml-2">{{ $movement->user->id }}</span>
                                            </div> --}}
                                            <div class="flex items-center">
                                                <span class="font-semibold">{{ __('Date') }}:</span>
                                                <span class="ml-2">{{ $movement->created_at }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-center py-4">{{ __('No movement recorded') }}</li>
                                    @endforelse
                                </ul>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </x-slot>
    </x-modal>
    <!-- End Show Modal -->
</div>
