<div 
    x-data="{ q: '{{ request('q') }}', timeout: null }" 
    class="flex items-center"
>
    <input 
        type="text" 
        x-model="q" 
        placeholder="Search..."
        class="rounded-full placeholder:tracking-wider w-48 sm:w-80 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
        @input="
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                window.location = '{{ $action ?? url()->current() }}' + '?q=' + encodeURIComponent(q);
            }, 1000);
        "
    >
</div>
