<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Bug Attachments
            </h2>

            <x-search action="{{ route('bugAttachments.index') }}" />

            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-attachment')"
                class="transform hover:scale-105 transition-transform duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Attachment
            </x-primary-button>
        </div>
    </x-slot>

    {{-- Grid Cards --}}
    <div class="p-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
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

        @if ($attachments->isEmpty())
            There is no reward data yet.
        @else
            @foreach ($attachments as $attachment)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition w-full max-w-xs mx-auto">
                    <img src="{{ asset('storage/foto/' . $attachment->file_path) }}"
                        class="w-full h-48 object-cover transform hover:scale-105 transition duration-300"
                        alt="Bug Attachment">

                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 truncate">
                            {{ $attachment->bugs?->title ?? 'Bug Tidak Ditemukan' }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Uploaded by: <span
                                class="bg-blue-100 rounded-full py-1 px-2 text-blue-600 font-semibold">{{ $attachment->user?->name ?? 'Unknown' }}</span>
                        </p>

                        @if (auth()->user()->role === 'admin' || auth()->user()->id === $attachment->uploaded_by)
                            <div class="mt-4 flex justify-evenly gap-2">
                                <x-primary-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'edit-attachment-{{ $attachment->id }}')">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </x-primary-button>

                                <form method="POST" action="{{ route('bugAttachments.destroy', $attachment) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this attachment?')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </x-danger-button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Modal Edit --}}
                <x-modal name="edit-attachment-{{ $attachment->id }}" focusable>
                    <form method="POST" action="{{ route('bugAttachments.update', $attachment) }}"
                        enctype="multipart/form-data" class="p-6">
                        @csrf
                        @method('PUT')
                        <h2
                            class="text-lg text-left font-semibold tracking-widest px-3 py-1 bg-gray-100 text-gray-900 dark:text-gray-100 w-fit rounded-full">
                            Edit Attachment
                        </h2>

                        <div class="mt-4">
                            <x-input-label for="bug_id" value="Select Bug" />
                            <x-select id="bug_id" name="bug_id" :options="$bugs->pluck('title', 'id')" :selected="old('bug_id', $attachment->bug_id)" required />
                        </div>

                        <div class="mt-4">
                            <input type="file" name="file" id="file-edit-{{ $attachment->id }}" accept="image/*"
                                onchange="previewImageEdit(event, {{ $attachment->id }})"
                                class="block w-full text-sm text-gray-500">
                        </div>

                        <div class="mt-3">
                            <img id="preview-edit-{{ $attachment->id }}"
                                src="{{ asset('storage/foto/' . $attachment->file_path) }}"
                                class="w-40 h-40 object-cover rounded-lg border">
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-danger-button x-on:click="$dispatch('close')">Cancel</x-danger-button>
                            <x-primary-button class="ml-3">Save</x-primary-button>
                        </div>
                    </form>
                </x-modal>
            @endforeach
        @endif
    </div>

    {{-- Modal Create --}}
    <x-modal name="create-attachment" focusable>
        <form method="POST" action="{{ route('bugAttachments.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            <h2
                class="text-lg text-left font-semibold tracking-widest px-3 py-1 bg-gray-100 text-gray-900 dark:text-gray-100 w-fit rounded-full">
                Create New Attachment
            </h2>

            {{-- Select Bug --}}
            <div class="mt-4">
                <x-input-label for="bug_id" value="Select Bug" />
                <x-select id="bug_id" name="bug_id" :options="$bugs->pluck('title', 'id')" required />
            </div>

            {{-- Input Foto --}}
            <div class="mt-4">
                <x-input-label for="file" value="Photo" />
                <input type="file" id="file" name="file" accept="image/*" onchange="previewImage(event)"
                    class="block w-full text-sm text-gray-500" required>
                <div class="mt-3">
                    <img id="preview" src="" class="hidden w-40 h-40 object-cover rounded-lg border">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-danger-button x-on:click="$dispatch('close')">Cancel</x-danger-button>
                <x-primary-button class="ml-3">Save</x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- Pagination --}}
    @if ($attachments->hasPages())
        <div class="px-10 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            {{ $attachments->links('vendor.pagination.simple') }}

        </div>
    @endif

    {{-- Script Preview --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImageEdit(event, id) {
            const input = event.target;
            const preview = document.getElementById('preview-edit-' + id);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
