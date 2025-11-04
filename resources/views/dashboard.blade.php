<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Welcome, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    <div class="py-8 px-6 space-y-8">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class=" bg-amber-400 bg dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <p class="text-md font-semibold tracking-widest text-white">Total Projects</p>
                <h3 class="mt-2 text-3xl font-bold text-white">{{ $totalProjects ?? 0 }}</h3>
            </div>

            <div class="bg-red-500 dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <p class="text-md font-semibold tracking-widest text-white">Total Bugs</p>
                <h3 class="mt-2 text-3xl font-bold text-white">{{ $totalBugs ?? 0 }}</h3>
            </div>

            <div class="bg-green-600 dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <p class="text-md font-semibold tracking-widest text-white">Bugs Resolved</p>
                <h3 class="mt-2 text-3xl font-bold text-white">{{ $resolvedBugs ?? 0 }}</h3>
            </div>

            <div class="bg-blue-600 dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <p class="text-md font-semibold tracking-widest text-white">Users</p>
                <h3 class="mt-2 text-3xl font-bold text-white">{{ $totalUsers ?? 0 }}</h3>
            </div>

        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Recent Bugs --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Recent Bugs</h3>

                <div class="space-y-3">
                    @forelse ($recentBugs as $bug)
                        <div
                            class="flex items-center justify-between p-4 rounded-xl border dark:border-gray-700 
                        bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div>
                                <p class="font-medium text-gray-800 dark:text-gray-100">{{ $bug->title ?? '-' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Project:
                                    <span class="font-semibold text-black">{{ $bug->projects?->project_name ?? '-' }}</span> •
                                    <span>
                                        @if ($bug->priority == 'Low')
                                            <span
                                                class="px-2.5 py-1 text-sm font-semibold bg-green-100 text-green-800 rounded-lg dark:bg-green-700 dark:text-green-100">
                                                {{ $bug->priority }}
                                            </span>
                                        @elseif ($bug->priority == 'Medium')
                                            <span
                                                class="px-2.5 py-1 text-sm font-semibold bg-yellow-100 text-yellow-800 rounded-lg dark:bg-yellow-700 dark:text-yellow-100">
                                                {{ $bug->priority }}
                                            </span>
                                        @elseif ($bug->priority == 'High')
                                            <span
                                                class="px-2.5 py-1 text-sm font-semibold bg-orange-100 text-orange-800 rounded-lg dark:bg-orange-700 dark:text-orange-100">
                                                {{ $bug->priority }}
                                            </span>
                                        @elseif ($bug->priority == 'Critical')
                                            <span
                                                class="px-2.5 py-1 text-sm font-semibold bg-red-200 text-red-800 rounded-lg dark:bg-red-700 dark:text-red-100">
                                                {{ $bug->priority }}
                                            </span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <span>
                                @if ($bug->status == 'In Progress')
                                    <span
                                        class="px-2.5 py-1 text-sm font-semibold bg-orange-100 text-orange-600 rounded-lg dark:bg-orange-700 dark:text-orange-300">
                                        {{ $bug->status }}
                                    </span>
                                @elseif ($bug->status == 'Resolved')
                                    <span
                                        class="px-2.5 py-1 text-sm font-semibold bg-green-100 text-green-800 rounded-lg dark:bg-green-700 dark:text-green-100">
                                        {{ $bug->status }}
                                    </span>
                                @endif
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Belum ada bug dilaporkan.</p>
                    @endforelse
                </div>

            </div>

            {{-- Placeholder Chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Bug Statistics</h3>

                @if (array_sum($bugCounts) === 0)
                    <div
                        class="h-64 flex items-center justify-center text-gray-400 dark:text-gray-500 border-2 border-dashed rounded-xl">
                        No bug data available
                    </div>
                @else
                    <canvas id="bugChart"></canvas>
                @endif
            </div>

        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('bugChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Critical', 'High', 'Medium', 'Low'],
                        datasets: [{
                            label: 'Bug Priority',
                            data: @json ($bugCounts),
                            backgroundColor: [
                                '#ef4444',
                                '#f97316',
                                '#eab308',
                                '#22c55e',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#6b7280'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
