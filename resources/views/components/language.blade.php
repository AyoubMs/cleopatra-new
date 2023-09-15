@props(['language'])

<div {{ $attributes->class(['flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-teal-700 bg-teal-100 border border-teal-300 ']) }}>
    <div class="text-xs font-normal leading-none max-w-full flex-initial">{{ $language }}</div>
    {{$slot}}
</div>
