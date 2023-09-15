@props([
    'selectedClient',
    'categories',
    /** @var \string[] */
    'fa_icons',
    'templates'
])

<div {{ $attributes->class(['text-xs text-gray-500 mb-4']) }}>{{$selectedClient['name'] ?? ''}}</div>
<div class="text-black-500 mb-4 text-xl">Choose a category</div>
@foreach($categories as $category)
    <div onclick="selectCategory({{ $category }})"
         class="cursor-pointer border flex flex-col py-4 justify-center shadow-lg px-8 mt-4">
        <div class="mb-2 flex items-center">
            @if($category->name !== 'MyScarlet')
                <i class="fa-solid fa-{{$fa_icons[$category->name]}}"></i>
            @else
                <img src="/logo/scarlet.svg"/>
            @endif
            <div class="text-xl mx-4">{{ $category->name }}</div>
        </div>
        @foreach($templates as $key=>$template)
            @if($category->name === $template->category->name)
                <span class="text-xs">- {{ $template->title }}</span>
            @endif
        @endforeach
    </div>
@endforeach
