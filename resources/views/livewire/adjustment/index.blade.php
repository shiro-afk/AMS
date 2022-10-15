<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-md-0 my-2">
            <select wire:model="perPage"
                class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if($this->selectedCount)
            <x-button danger wire:click="deleteSelected" class="ml-3">
                <i class="fas fa-trash"></i>
            </x-button>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
            <div class="my-2 my-md-0">
                <input type="text" wire:model.debounce.300ms="search"
                    class="p-3 leading-5 bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-300 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <x-input type="checkbox" wire:model="selectPage" />
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">
                {{ __('Name') }}
                @include('components.table.sort', ['field' => 'name'])
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('description')" :direction="$sorts['description'] ?? null">
                {{ __('Description') }}
                @include('components.table.sort', ['field' => 'description'])
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('created_at')" :direction="$sorts['created_at'] ?? null">
                {{ __('Created At') }}
                @include('components.table.sort', ['field' => 'created_at'])
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('updated_at')" :direction="$sorts['updated_at'] ?? null">
                {{ __('Updated At') }}
                @include('components.table.sort', ['field' => 'updated_at'])
            </x-table.th>
            <x-table.th>{{ __('Actions') }}</x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse ($adjustments as $adjustment)
                <x-table.tr wire:key="row-{{ $adjustment->id }}">
                    <x-table.td>
                        <input wire:model="selected" value="{{ $adjustment->id }}" />
                    </x-table.td>
                    <x-table.td>{{ $adjustment->name }}</x-table.td>
                    <x-table.td>{{ $adjustment->description }}</x-table.td>
                    <x-table.td>{{ $adjustment->created_at->format('d/m/Y') }}</x-table.td>
                    <x-table.td>{{ $adjustment->updated_at->format('d/m/Y') }}</x-table.td>
                    <x-table.td>
                        <div class="flex justify-center">

                            <a href="{{ route('adjustments.show', $adjustment->id) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                wire:loading.attr="disabled">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('adjustments.edit', $adjustment->id) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </a>

                            <button type="button" wire:click="confirm('delete', {{ $adjustment->id }})"
                                wire:loading.attr="disabled"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-trash"></i>
                            </button>

                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="6">
                        <div class="flex justify-center">
                            {{ __('No results found') }}
                        </div>
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
            {{ $adjustments->links() }}
        </div>
    </div>
</div>

@push('page_scripts')
    <script>
        window.addEventListener('confirm', event => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('delete', event.detail.id)
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        })
    </script>
@endpush
