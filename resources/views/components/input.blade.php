@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'type' => '',
    'placeholder' => '',
    'class' => ''
])

<label class="block text-gray-700 text-sm font-bold mb-2" for="{{ $name }}">
    {{ $label }}
</label>
<input name="{{ $name }}"
       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ $class }}"
       id="{{ $name }}"
       type="{{ $type }}"
       placeholder="{{ $placeholder }}"
       value="{{ $value }}"
/>
@error($name)
<p class="text-red-500 text-xs italic">
    {{ $message }}
</p>
@enderror
