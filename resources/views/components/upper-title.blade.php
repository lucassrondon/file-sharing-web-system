@props(['overflowCase' => 'break-all'])

<h2 {{ $attributes->merge(['class' => "{$overflowCase} font-semibold text-black uppercase tracking-widest"]) }} >
    {{ $slot }}
</h2>