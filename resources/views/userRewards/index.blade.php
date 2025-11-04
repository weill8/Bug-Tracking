<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                User Rewards
            </h2>

            <x-search action="{{ route('userRewards.index') }}" />

            @if (auth()->user()->role === 'admin')
                <!-- Tombol Create -->
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-reward')"
                    class="transform hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Reward
                </x-primary-button>
            @endif
        </div>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8">
        {{-- Flash message --}}
        @if (session('success'))
            <x-modal name="success-alert" :show="true" focusable>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <h2 class="text-xl font-bold text-green-700">Success!</h2>
                    </div>

                    <p class="text-green-600 mb-6">{{ session('success') }}</p>

                    <div class="flex justify-end">
                        <x-primary-button autofocus x-on:click="$dispatch('close', 'success-alert')">
                            OK
                        </x-primary-button>

                    </div>
                </div>
            </x-modal>
        @endif

        <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <x-table :headers="auth()->user()->role === 'admin' 
                ? ['ID', 'User', 'Bugs Resolved', 'Total Reward', 'Date', 'Actions'] 
                : ['ID', 'User', 'Bugs Resolved', 'Total Reward', 'Date']">               
                @forelse ($rewards as $reward)
                    <x-table.row hover>
                        <x-table.cell>
                            <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 rounded-lg">
                                #{{ $reward->id }}
                            </span>
                        </x-table.cell>

                        <x-table.cell class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $reward->user?->email }}
                        </x-table.cell>

                        <x-table.cell class="text-gray-500 dark:text-gray-400">
                            {{ $reward->bugs_resolved }}
                        </x-table.cell>

                        <x-table.cell class="text-gray-500 dark:text-gray-400">
                            Rp {{ number_format($reward->total_bonus, 0, ',', '.') }}
                        </x-table.cell>

                        <x-table.cell class="text-gray-500 dark:text-gray-400">
                            {{ $reward->date ?? '-' }}
                        </x-table.cell>

                        @if (auth()->user()->role === 'admin')
                            <x-table.cell>
                                <div class="flex justify-center space-x-3">
                                    {{-- Edit --}}
                                    <form action="{{ route('userRewards.update', $reward->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="user_id" value="{{ $reward->user_id }}">
                                        <x-primary-button 
                                            class="text-sm bg-lime-500 active:bg-lime-500 hover:bg-lime-500 transform hover:scale-105 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M20.49 9A9 9 0 1 0 21 12"></path>
                                                <polyline points="21 3 21 9 15 9"></polyline>
                                                </svg>
                                            Update
                                        </x-primary-button>
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('userRewards.destroy', $reward) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit"
                                            onclick="return confirm('Yakin mau hapus reward ini?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            delete
                                        </x-danger-button>
                                    </form>
                                </div>

                                {{-- Edit Modal --}}
                                {{-- <x-modal name="edit-reward-{{ $reward->id }}">
                                    <form method="POST" action="{{ route('userRewards.update', $reward) }}"
                                        class="p-6">
                                        @csrf
                                        @method('PUT')

                                        <h2
                                            class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                                            Edit Reward
                                        </h2>

                                        <div class="mt-6">
                                            <x-input-label for="user_id_{{ $reward->id }}" value="Pilih User" />
                                            <x-select name="user_id" id="user_id_{{ $reward->id }}" :options="$users->pluck('email', 'id')"
                                                required :selected="old('user_id', $reward->user_id)" />
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <x-danger-button x-on:click="$dispatch('close')">
                                                Cancel
                                            </x-danger-button>
                                            <x-primary-button class="ml-3">
                                                Simpan
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </x-modal> --}}
                            </x-table.cell>
                        @endif
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="6" class="text-center py-4">
                            There is no reward data yet.
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-table>
        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-reward">
        <form method="POST" action="{{ route('userRewards.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                Create New Reward
            </h2>

            <div class="mt-6">
                <x-input-label for="user_id" value="Pilih User" />
                <x-select name="user_id" id="user_id" :options="$users->pluck('email', 'id')" required />
            </div>

            <div class="mt-6 flex justify-end">
                <x-danger-button x-on:click="$dispatch('close')">
                    Batal
                </x-danger-button>
                <x-primary-button class="ml-3">
                    Simpan
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
