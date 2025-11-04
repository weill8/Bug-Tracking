<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Bug Logs
            </h2>

            <x-search action="{{ route('bugLogs.index') }}" />

            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-bug-logs')"
                class="transform hover:scale-105 transition-transform duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Log
            </x-primary-button>
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

        {{-- modal create --}}
        <x-modal name="create-bug-logs" :show="$errors->any()" focusable>
            <form method="POST" action="{{ route('bugLogs.store') }}" class="p-6">
                @csrf

                <h2
                    class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                    Create New Log
                </h2>

                <div class="mt-6">
                    <x-input-label for="bug_id" value="Project Name" />
                    <x-select name="bug_id" id="bug_id" :options="$bugs" required />
                    <x-input-error :messages="$errors->get('bug_id')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-input-label for="new_status" value="New Status" />
                    <x-select name="new_status" id="new_status" :options="$statuses" required />
                    <x-input-error :messages="$errors->get('new_status')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-danger-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-danger-button>

                    <x-primary-button>
                        Save
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        {{-- table --}}
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">

            <x-table :headers="['ID', 'Bug Title', 'Changed by', 'Status', 'Actions']">
                @if ($bugLogs->isEmpty())
                    <x-table.row>
                        <x-table.cell colspan="5" class="text-center py-4">
                            There is no reward data yet.
                        </x-table.cell>
                    </x-table.row>
                @else
                    @foreach ($bugLogs as $bugLog)
                        <x-table.row hover>
                            <x-table.cell>
                                <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    #{{ $bugLog->id }}
                                </span>
                            </x-table.cell>

                            <x-table.cell
                                class="font-medium truncate max-w-[155px] text-gray-900 dark:text-gray-100">{{ $bugLog->bugs?->title }}
                            </x-table.cell>

                            <x-table.cell
                                class="text-gray-500 truncate max-w-[155px] dark:text-gray-400">{{ $bugLog->changed?->name ?? '-' }}
                            </x-table.cell>

                            <x-table.cell class="text-gray-500 truncate max-w-[155px] dark:text-gray-400">
                                @if ($bugLog->new_status == 'In Progress')
                                    <span
                                        class="px-2.5 py-1 text-sm font-semibold bg-orange-100 text-orange-600 rounded-lg dark:bg-orange-700 dark:text-orange-300">
                                        {{ $bugLog->new_status }}
                                    </span>
                                @elseif ($bugLog->new_status == 'Resolved')
                                    <span
                                        class="px-2.5 py-1 text-sm font-semibold bg-green-100 text-green-800 rounded-lg dark:bg-green-700 dark:text-green-100">
                                        {{ $bugLog->new_status }}
                                    </span>
                                @endif
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex justify-center space-x-3">

                                    {{-- edit --}}
                                    <x-primary-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'edit-bug-log-{{ $bugLog->id }}')"
                                        class="text-sm bg-green-600 active:bg-green-700 hover:bg-green-700 transform hover:scale-105 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </x-primary-button>

                                    {{-- show --}}
                                    <x-blue-button x-data=""
                                        class="text-sm transform hover:scale-105 transition-all duration-200"
                                        x-on:click.prevent="$dispatch('open-modal', 'show-bug-log-{{ $bugLog->id }}')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Show
                                    </x-blue-button>

                                    {{-- delete --}}
                                    <form action="{{ route('bugLogs.destroy', $bugLog) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this log?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </x-danger-button>
                                    </form>
                                </div>

                                {{-- Edit modal --}}
                                <x-modal name="edit-bug-log-{{ $bugLog->id }}">
                                    <form method="POST" action="{{ route('bugLogs.update', $bugLog) }}"
                                        class="p-6">
                                        @csrf
                                        @method('PUT')

                                        <h2
                                            class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                                            Edit Log
                                        </h2>

                                        <div class="mt-6">
                                            <x-input-label for="bug_id{{ $bugLog->id }}" value="Project Name" />
                                            <x-select name="bug_id" id="bug_id{{ $bugLog->id }}" :options="$bugs"
                                                required :selected="old('bug_id', $bugLog->bug_id)" />
                                            <x-input-error :messages="$errors->get('bug_id')" class="mt-2" />
                                        </div>

                                        <div class="mt-6">
                                            <x-input-label for="new_status_{{ $bugLog->id }}" value="Priority" />
                                            <x-select name="new_status" id="new_status_{{ $bugLog->id }}"
                                                :options="$statuses" required :selected="old('new_status', $bugLog->new_status)" />
                                            <x-input-error :messages="$errors->get('new_status')" class="mt-2" />
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <x-danger-button x-on:click="$dispatch('close')">
                                                Cancel
                                                </x-dang-button>

                                                <x-primary-button
                                                    class="ml-3 bg-green-600 active:bg-green-700 hover:bg-green-700">
                                                    Update
                                                </x-primary-button>
                                        </div>
                                    </form>
                                </x-modal>

                                {{-- Show modal --}}
                                <x-modal name="show-bug-log-{{ $bugLog->id }}">
                                    <div class="p-6">

                                        <h2
                                            class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                                            Log Detail
                                        </h2>

                                        <div class="mt-6">
                                            <x-input-label for="bug_id{{ $bugLog->id }}" value="Bug Title" />
                                            <x-text-input id="bug_id{{ $bugLog->id }}" disabled="true"
                                                name="bug_id" type="text" class="mt-1 block w-full"
                                                value="{{ $bugLog->bugs?->title ?? '-' }}" required />
                                            <x-input-error :messages="$errors->get('bug_id')" class="mt-2" />
                                        </div>

                                        <div class="mt-6">
                                            <x-input-label for="new_status_{{ $bugLog->id }}" value="Status" />
                                            <x-text-input id="new_status_{{ $bugLog->id }}" disabled="true"
                                                name="new_status" type="text" class="mt-1 block w-full"
                                                value="{{ $bugLog->new_status ?? '-' }}" required />
                                            <x-input-error :messages="$errors->get('new_status')" class="mt-2" />
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <x-danger-button x-on:click="$dispatch('close')">
                                                Close
                                            </x-danger-button>
                                        </div>
                                    </div>
                                </x-modal>

                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                @endif
            </x-table>

            {{-- Pagination --}}
            @if ($bugLogs->hasPages())
                <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $bugLogs->links('vendor.pagination.simple') }}

                </div>
            @endif
        </div>
    </div>
</x-app-layout>
