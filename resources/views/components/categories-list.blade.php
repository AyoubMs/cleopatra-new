@props([
    'categories',
    /** @var \string[] */
    'fa_icons',
    'templates',
    'selectedClient',
    'selectedCategory'
])

<div {{ $attributes->class(['text-xs text-gray-500 mb-4']) }}>{{$selectedClient['name']}}
    / {{$selectedCategory['name']}}</div>
<div onclick="categoriesAndTemplates()" class="flex items-center cursor-pointer">
    <i class="fa-solid fa-arrow-left" style="color: #4182f6;"></i>
    <div class="mx-2 underline text-blue-500 text-xl">Choose a category</div>
</div>
<div class="mb-2 flex items-center mt-5">
    @if($selectedCategory['name'] !== 'MyScarlet')
        <i class="fa-solid fa-{{$fa_icons[$selectedCategory['name']]}}"></i>
    @else
        <img src="/logo/scarlet.svg"/>
    @endif
    <div class="text-xl mx-4">{{ $selectedCategory['name'] }}</div>
</div>
@foreach($templates as $template)
    <div wire:click.prevent="selectTemplate({{ $template }})"
         class="cursor-pointer border flex flex-col py-4 justify-center shadow-lg px-8 mt-4">
        <div class="text-xl mb-4">{{ $template->title }}</div>
        <div>{{ Str::limit($template->template_var, 500) }}</div>
    </div>
@endforeach
