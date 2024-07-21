@props([
    'type' => 'success',
    'colors' => [
        'success' => 'bg-green-400',
        'warning' => 'bg-orange-400',
        'error' => 'bg-red-400',
    ]
])

<div class="text-white {{ $colors[$type] }} px-6 py-2">
    {{ $slot }}
</div>
