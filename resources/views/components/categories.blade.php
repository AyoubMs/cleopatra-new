@props([
    'selectedClient',
    'categories',
    /** @var \string[] */
    'fa_icons',
    'templates',
    'search',
    'searchedTemplates'
])

<div {{ $attributes->class(['text-xs text-gray-500 mb-4']) }}>{{$selectedClient['name'] ?? ''}}</div>
<div class="text-black-500 mb-4 text-xl">Choose a category</div>
<div class="mb-6 flex">
    <input class="border border-gray-400 p-2 w-full rounded-s-md"
           type="text"
           placeholder="e.g. SIM card, PUK code, ..."
           name="template_search"
           id="template_search"
           wire:model.live="search"
           required
    />
    <button class="bg-blue-500 flex items-center text-white w-12 justify-center rounded-e-md">
        <i class="fa-solid fa-magnifying-glass text-2xl"></i>
    </button>
</div>
@if(!$search || $search === "")
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
@elseif($searchedTemplates)
    @foreach($searchedTemplates as $searchedTemplate)
        <div class="cursor-pointer border flex flex-col py-4 justify-center shadow-lg px-8 mt-4" onclick="selectTemplateTemplates({{ $searchedTemplate }})">
            <div class="mb-2 flex items-center">{{ $searchedTemplate->title }}</div>
            <div>
                {{Str::limit($searchedTemplate->template_var, 500)}}
            </div>
        </div>
    @endforeach
@endif
