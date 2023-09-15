@props(['language'])

<div {{ $attributes->class(['cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100']) }}>
    <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
        <div class="w-full items-center flex">
            <div class="mx-2 leading-6">{{ $language }}</div>
        </div>
    </div>
</div>
