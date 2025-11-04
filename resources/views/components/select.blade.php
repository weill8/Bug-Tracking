@props(['disabled' => false, 'options' => [], 'required' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
]) !!} {{ $required ? 'required' : '' }}>
    <option value="">Select an option</option>
    @foreach ($options as $key => $value)
        <option value="{{ $key }}" @selected($attributes->get('selected') == $key)>{{ $value }}</option>
    @endforeach
</select>
