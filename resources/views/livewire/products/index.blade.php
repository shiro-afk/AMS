<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
            <select wire:model="perPage"
                class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($selected)
                <x-button danger type="button" wire:click="deleteSelectedModal" class="ml-3">
                    <i class="fas fa-trash"></i>
                </x-button>
                <x-button primary type="button" wire:click="printSelectedQRCodes" class="ml-3">
                    <i class="fas fa-qrcode"></i> {{ __('Print QR Code') }}
                </x-button>
            @endif
            @if ($this->selectedCount)
                <p class="p-4 text-sm leading-5 text-center">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
            <div class="my-2">
                <x-input wire:model.debounce.500ms="search" placeholder="{{ __('Search') }}" autofocus />
            </div>
        </div>
        <div class="w-full flex justify-start items-center">
            <x-label for="category" :value="__('Filter by category')" />
            <select wire:model="category_id" name="category_id" id="category_id"
                class="w-full block py-2 px-3 ml-2 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                <option value="all"> {{ __('View All') }} </option>
                @foreach ($this->categories as $index => $category)
                    <option value="{{ $index }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                #
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">
               {{ __('Name') }}
            </x-table.th>
            {{--<x-table.th>
                {{ __('Quantity') }}
            </x-table.th>
            <x-table.th class="p-2 text-center text-gray-800 ">
                {{ __('Price') }}
            </x-table.th>--}}
            <x-table.th class="p-2 text-center text-gray-800 ">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th  class="p-2 text-center text-gray-800 " sortable wire:click="sortBy('category_id')" :direction="$sorts['category_id'] ?? null">
                {{ __('Category') }}
            </x-table.th>
            <x-table.th class="p-2 text-center text-gray-800 "  >
                {{ __('School') }}
            </x-table.th>
            <x-table.th class="p-2 text-center text-gray-800 ">
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($products as $product)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $product->id }}">
                    <x-table.td class="text-center">
                        <input type="checkbox" value="{{ $product->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td class="p-2 text-center text-gray-800 ">
                        <button type="button" wire:click="$emit('showModal',{{ $product->id }})"
                            class="whitespace-nowrap hover:text-blue-400 active:text-blue-400">
                            {{ $product->name }} <br>
                            <x-badge type="success">
                                {{ $product->code }}
                            </x-badge>
                        </button>
                    </x-table.td>
                  {{--  <x-table.td>{{ $product->total_quantity }}</x-table.td>
                    <x-table.td class="p-2 text-center text-gray-800 ">{{ format_currency($product->average_price) }}</x-table.td>--}}
                    <x-table.td class="p-2 text-center text-gray-800 ">{{ $product->tax_type }}</x-table.td>
                    <x-table.td >
                        <x-button type="button" warning x-on:click="$wire.category_id = {{ $product->category->id }}">
                            {{ $product->category->name }}
                            <small>
                                ({{ $product->ProductsByCategory($product->category->id) }})
                            </small>
                        </x-button>
                    </x-table.td>
                    <x-table.td class="p-2 text-center text-gray-800 ">{{ optional($product->brand)->name }}</x-table.td>
                    <x-table.td class="p-2 text-center text-gray-800 ">
                        <x-dropdown align="right" width="56">
                            <x-slot name="trigger" class="inline-flex">
                                <x-button primary type="button" class="text-white flex items-center">
                                    <i class="fas fa-angle-double-down"></i>
                                </x-button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link wire:click="$emit('showModal',{{ $product->id }})"
                                    wire:loading.attr="disabled" class="text-left ">
                                    <i class="fas fa-eye"></i>
                                    {{ __('View') }}
                                </x-dropdown-link>
                              {{-- @if (settings()->telegram_channel)
                                    <x-dropdown-link wire:click="sendTelegram({{ $product->id }})"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-paper-plane"></i>
                                        {{ __('Send to telegram') }}
                                    </x-dropdown-link>
                                @endif
                                <x-dropdown-link wire:click="sendWhatsapp({{ $product->id }})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-paper-plane"></i>
                                    {{ __('Send to Whatsapp') }}
                                </x-dropdown-link>--}}
                                <x-dropdown-link wire:click="$emit('editModal', {{ $product->id }})"
                                    wire:loading.attr="disabled" class="text-left">
                                    <i class="fas fa-edit"></i>
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="deleteModal({{ $product->id }})"
                                    wire:loading.attr="disabled"  class="text-left">
                                    <i class="fas fa-trash"></i>
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="8" class="text-center">
                        {{ __('No Item found') }}
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="p-4">
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $products->links() }}
        </div>
    </div>

    <!-- Show Modal -->
    @livewire('products.show', ['product' => $product], key('show-modal-' . $product?->id))
    <!-- End Show Modal -->

    <!-- Edit Modal -->
    @livewire('products.edit', ['product' => $product], key('edit-modal-' . $product?->id))
    <!-- End Edit Modal -->

    <livewire:products.create />

    {{-- Import modal --}}

    <x-modal wire:model="importModal">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                {{ __('Import Excel') }}
                <x-button primary wire:click="downloadSample" type="button">
                    {{ __('Download Sample') }}
                </x-button>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="import">
                <div class="space-y-4">
                    <div class="mt-4">
                        <x-label for="import" :value="__('Import')" />
                        <x-input id="import" class="block mt-1 w-full" type="file" name="import"
                            wire:model.defer="import" />
                        <x-input-error :messages="$errors->get('import')" for="import" class="mt-2" />
                    </div>

                    <div class="w-full px-3">
                        <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                            {{ __('Import') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
@push('scripts')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        Livewire.on('printQRCodes', function (qrCodeDataUris) {
    // Create a temporary hidden div to hold the QR code images
    const printContainer = document.createElement('div');
    printContainer.style.visibility = 'hidden';
    document.body.appendChild(printContainer);

    // Add QR code images to the container
    qrCodeDataUris.forEach(dataUri => {
        const img = document.createElement('img');
        img.src = dataUri;
        printContainer.appendChild(img);
    });

    // Use html2canvas to capture the content of the container
    html2canvas(printContainer, {
        onrendered: function (canvas) {
            // Convert the canvas to a data URL
            const dataUrl = canvas.toDataURL();

            // Create an iframe and set its source to the data URL
            const iframe = document.createElement('iframe');
            iframe.src = dataUrl;
            iframe.style.width = '0';
            iframe.style.height = '0';
            document.body.appendChild(iframe);

            // Initiate the printing process
            iframe.contentWindow.print();

            // Remove the iframe from the DOM after printing
            iframe.remove();
        }
    });
});

    </script>
@endpush

