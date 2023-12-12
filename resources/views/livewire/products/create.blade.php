<div>
    <!-- Create Modal -->
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Add Item') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="create">
                <x-validation-errors class="mb-4" :errors="$errors" />
                <div>
                    <div class="flex flex-wrap mb-3">
                        <div class="md:w-1/2 sm:w-full px-3">
                            <x-label for="code" :value="__('Code')" required />
                            <x-input id="code" class="block mt-1 w-full bg-gray-200 bg-opacity-75 p-2 rounded pointer-events-none"
                                type="text" name="code" wire:model.lazy="product.code"
                                placeholder="{{ __('Enter Product Code') }}" required autofocus readonly />
                            <x-input-error :messages="$errors->get('code')" for="code" class="mt-2" />
                        </div>


                        <div class="md:w-1/2 sm:w-full px-2">
                            <x-label for="name" :value="__('Item name')" required />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                wire:model.lazy="product.name" placeholder="{{ __('Enter Item Name') }}" required />
                            <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                        </div>
                        <div class="md:w-1/2 sm:w-full px-2">
                            <x-label for="category" :value="__('Category')" required />
                            <x-select-list :options="$this->categories" id="category_create" name="category_create"
                                wire:model="product.category_id" />
                            <x-input-error :messages="$errors->get('category_id')" for="category_id" class="mt-2" />
                        </div>
                        {{--<div class="md:w-1/2 sm:w-full px-2">
                            <x-label for="stock_alert" :value="__('Stock Alert')" />
                            <x-input id="stock_alert" class="block mt-1 w-full" type="text" name="stock_alert"
                                wire:model.lazy="product.stock_alert" />
                            <x-input-error :messages="$errors->get('stock_alert')" for="stock_alert" class="mt-2" />
                        </div>--}}
                        <div class="md:w-1/2 sm:w-full px-2">
                            <x-label for="item_status" :value="__('Item Status')" />
                            <select class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                    wire:model.lazy="product.tax_type" name="tax_type">
                                <option value="">
                                    {{ __('Choose Status') }}
                                </option>
                                <option value="Good Condition">{{ __('Good Condition') }}</option>
                                <option value="Unserviceable">{{ __('Unserviceable') }}</option>
                                <option value="Serviceable">{{ __('Serviceable') }}</option>
                                <option value="For Disposal">{{ __('For Disposal') }}</option>
                                <option value="For Warranty">{{ __('For Warranty') }}</option>
                                <option value="Disposed">{{ __('Disposed') }}</option>
                                <option value="Missing">{{ __('Missing') }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="flex flex-wrap mb-3">
                        <div class="md:w-1/2 sm:w-full px-2">
                            <x-label for="brand" :value="__('School')" />
                            <x-select-list :options="$this->brands" id="brand_id" name="brand_id"
                                wire:model="product.brand_id" />
                            <x-input-error :messages="$errors->get('brand_id')" for="brand_id" class="mt-2" />
                        </div>
                    {{--<div class="flex flex-col justify-center px-2 mt-2 border border-gray-300 rounded-md">

                            <div class="flex items-center w-full gap-2 py-4">
                                <div class="w-1/4">
                                    <label for="warehouseSearch" class="font-semibold text-left">Search School:</label>
                                    <input
                                        type="text"
                                        id="warehouseSearch"
                                        name="warehouseSearch"
                                        class="block w-full mt-1"
                                        list="warehouseOptions"
                                        placeholder="Type to search..."
                                    >
                                    <datalist id="warehouseOptions">
                                        @foreach ($this->warehouses as $warehouse)
                                            <option value="{{ $warehouse->name }}">
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="w-1/4">
                                    <x-label for="quantity_{{ $warehouse->id }}" :value="__('Quantity')" />
                                    <input id="quantity_{{ $warehouse->id }}" class="block mt-1 w-full" type="text"
                                        name="quantity_{{ $warehouse->id }}"
                                        placeholder="{{ __('Enter Product Quantity') }}"
                                        wire:model.defer="productWarehouse.{{ $warehouse->id }}.quantity" />
                                    <x-input-error :messages="$errors->get('quantity.' . $warehouse->id)" for="price_{{ $warehouse->id }}"
                                        class="mt-2" />
                                </div>
                                <div class="w-1/4">
                                    <x-label for="price_{{ $warehouse->id }}" :value="__('Price')" />
                                    <input id="price_{{ $warehouse->id }}" class="block mt-1 w-full" type="text"
                                        name="price_{{ $warehouse->id }}"
                                        wire:model.lazy="productWarehouse.{{ $warehouse->id }}.price"
                                        placeholder="{{ __('Enter Product Price') }}" />
                                    <x-input-error :messages="$errors->get('prices.' . $warehouse->id)" for="price_{{ $warehouse->id }}"
                                        class="mt-2" />
                                </div>
                                <div class="w-1/4">
                                    <x-label for="cost_{{ $warehouse->id }}" :value="__('Cost')" />
                                    <input type="text" wire:model.lazy="productWarehouse.{{ $warehouse->id }}.cost"
                                        id="cost_{{ $warehouse->id }}" name="cost_{{ $warehouse->id }}"
                                        class="block mt-1 w-full" placeholder="{{ __('Enter Product Cost') }}" />
                                    <x-input-error :messages="$errors->get('costs.' . $warehouse->id)" for="cost_{{ $warehouse->id }}" class="mt-2" />
                                </div>
                            </div>

                    </div>--}}

                    <x-accordion title="{{ __('Details') }}">
                        <div class="flex flex-wrap mb-3">
                          {{--  <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="brand" :value="__('Brand')" />
                                <x-select-list :options="$this->brands" id="brand_id" name="brand_id"
                                    wire:model="product.brand_id" />
                                <x-input-error :messages="$errors->get('brand_id')" for="brand_id" class="mt-2" />
                            </div>
                           <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="order_tax" :value="__('Tax')" />
                                <x-input id="order_tax" class="block mt-1 w-full" type="text" name="order_tax"
                                    wire:model.lazy="product.order_tax" placeholder="{{ __('Enter Tax') }}" />
                                <x-input-error :messages="$errors->get('order_tax')" for="order_tax" class="mt-2" />
                            </div>

                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="tax_type" :value="__('Status')" />
                                <select
                                    class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                    wire:model.lazy="product.tax_type" name="tax_type">
                                    <option value="" selected disabled>
                                        {{ __('Select Tax Type') }}
                                    </option>
                                    <option value="Exclusive">{{ __('Exclusive') }}</option>
                                    <option value="Inclusive">{{ __('Inclusive') }}</option>
                                </select>
                            </div>
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="unit" :value="__('Unit')"
                                    tooltip="{{ __('This text will be placed after Product Quantity') }}" />
                                <x-input id="unit" class="block mt-1 w-full" type="text" name="unit"
                                    wire:model.lazy="product.unit" placeholder="{{ __('Enter Unit') }}" />
                                <x-input-error :messages="$errors->get('unit')" for="unit" class="mt-2" />
                            </div>
                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="barcode_symbology" :value="__('Barcode Symbology')" required />
                                <select wire:model.lazy="product.barcode_symbology"
                                    class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                    name="barcode_symbology" id="barcode_symbology" required>
                                    <option value="C128" selected>Code 128</option>
                                    <option value="C39">Code 39</option>
                                    <option value="UPCA">UPC-A</option>
                                    <option value="UPCE">UPC-E</option>
                                    <option value="EAN13">EAN-13</option>
                                    <option value="EAN8">EAN-8</option>
                                </select>
                                <x-input-error :messages="$errors->get('barcode_symbology')" for="barcode_symbology" class="mt-2" />
                            </div>
                            <div class="md:w-1/2 sm:w-full px-4 gap-2">
                                <x-label for="featured" :value="__('Favorite proudct')" />
                                <x-input.checkbox id="featured" type="checkbox" name="featured"
                                    wire:model.lazy="product.featured" />
                                <x-input-error :messages="$errors->get('featured')" for="featured" class="mt-2" />
                            </div>
                            --}}
                            <div class="w-full px-2">
                                <x-label for="note" :value="__('Description')" />
                                <textarea wire:model.lazy="product.note" name="note"
                                    class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </x-accordion>

                   {{-- <div class="w-full px-2">
                        <x-label for="image" :value="__('Image')" />
                        <x-fileupload wire:model="image" :file="$image" accept="image/jpg,image/jpeg,image/png" />
                        <x-input-error :messages="$errors->get('image')" for="image" class="mt-2" />
                    </div>
                        --}}
                        <div class="w-full my-3 flex justify-center">
                            <button type="submit" wire:loading.attr="disabled" class="w-full bg-indigo-500 text-white py-2 px-4 rounded">
                                {{ __('Create') }}
                            </button>
                        </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Create Modal -->
</div>
