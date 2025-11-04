<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Projects
            </h2>

            <x-search action="{{ route('projects.index') }}" />

            @if (auth()->user()->role === 'admin')
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-project')"
                    class="transform hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Project
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

        {{-- modal create project --}}
        <x-modal name="create-project" :show="$errors->any()" focusable>
            <form method="POST" action="{{ route('projects.store') }}" class="p-6">
                @csrf

                <h2
                    class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                    Create New Project
                </h2>

                <div class="mt-6">
                    <x-input-label for="project_name" value="Project Name" />
                    <x-text-input id="project_name" name="project_name" type="text" required />
                    <x-input-error :messages="$errors->get('project_name')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
            <x-table :headers="['ID', 'Project Name', 'Description', 'Actions']">
                @if ($projects->isEmpty())
                    <x-table.row>
                        <x-table.cell colspan="4" class="text-center py-4">
                            There is no reward data yet.
                        </x-table.cell>
                    </x-table.row>
                @else
                    @foreach ($projects as $project)
                        <x-table.row hover>
                            <x-table.cell>
                                <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    #{{ $project->id }}
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $project->project_name }}
                                </div>
                            </x-table.cell>
                            <x-table.cell
                                class="text-gray-500 truncate max-w-40 dark:text-gray-400">{{ $project->description ?? '-' }}
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex justify-center space-x-3">

                                    {{-- show --}}
                                    <x-blue-button x-data=""
                                        class="text-sm transform hover:scale-105 transition-all duration-200"
                                        x-on:click.prevent="$dispatch('open-modal', 'show-project-{{ $project->id }}')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                        Show
                                    </x-blue-button>

                                    @if(auth()->user()->role === 'admin')
                                    {{-- edit --}}
                                    <x-primary-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'edit-project-{{ $project->id }}')"
                                        class="text-sm bg-green-600 active:bg-green-700 hover:bg-green-700 transform hover:scale-105 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </x-primary-button>

                                    {{-- delete --}}
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this project?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </x-danger-button>
                                    </form>
                                    @endif
                                </div>

                                {{-- Edit modal --}}
                                <x-modal name="edit-project-{{ $project->id }}">
                                    <form method="POST" action="{{ route('projects.update', $project) }}"
                                        class="p-6">
                                        @csrf
                                        @method('PUT')

                                        <h2
                                            class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                                            Edit Project
                                        </h2>

                                        <div class="mt-6">
                                            <x-input-label for="project_name_{{ $project->id }}"
                                                value="Project Name" />
                                            <x-text-input id="project_name_{{ $project->id }}" name="project_name"
                                                type="text" class="mt-1 block w-full"
                                                value="{{ $project->project_name }}" required />
                                            <x-input-error :messages="$errors->get('project_name')" class="mt-2" />
                                        </div>

                                        <div class="mt-6">
                                            <x-input-label for="description_{{ $project->id }}"
                                                value="Description" />
                                            <textarea id="description_{{ $project->id }}" name="description"
                                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $project->description }}</textarea>
                                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <x-danger-button x-on:click="$dispatch('close')">
                                                Cancel
                                            </x-danger-button>

                                            <x-primary-button>
                                                Update
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </x-modal>

                                {{-- Show modal --}}
                                <x-modal name="show-project-{{ $project->id }}">
                                    <div class="p-6">

                                        <h2
                                            class="text-lg font-semibold tracking-widest px-2 py-1 bg-gray-100 text-gray-900 dark:text-gray-100">
                                            Project Detail
                                        </h2>

                                        <div class="mt-6">
                                            <x-input-label for="project_name_{{ $project->id }}"
                                                value="Project Name" />
                                            <x-text-input id="project_name_{{ $project->id }}" disabled="true"
                                                name="project_name" type="text" class="mt-1 block w-full"
                                                value="{{ $project->project_name }}" required />
                                            <x-input-error :messages="$errors->get('project_name')" class="mt-2" />
                                        </div>

                                        <div class="mt-6">
                                            <x-input-label for="description_{{ $project->id }}"
                                                value="Description" />
                                            <textarea id="description_{{ $project->id }}" disabled="true" name="description"
                                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $project->description }}</textarea>
                                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
            @if ($projects->hasPages())
                <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $projects->appends(['q' => request('q')])->links('vendor.pagination.simple') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
