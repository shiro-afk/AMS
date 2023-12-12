<div>
    <!-- Create Modal -->
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Category') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit.prevent="create">
                <div>
                    <div class="my-4">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" autofocus
                            wire:model.lazy="category.name"  />
                        <x-input-error :messages="$errors->get('category.name')" for="name" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <button primary type="submit" class="w-full text-center mx-auto bg-indigo-500 border border-transparent text-white hover:bg-indigo-600 focus:ring-indigo-500 active:bg-indigo-900 focus:outline-none focus:border-indigo-900"  wire:loading.attr="disabled">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Create Modal -->
</div>
