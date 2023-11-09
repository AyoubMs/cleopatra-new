@props([
    'categories',
    /** @var \string[] */
    'fa_icons',
    'templates',
    'selectedCategory',
    'selectedTemplate'
])

<div onclick="templateAndTemplates()" {{ $attributes->class(['flex items-center cursor-pointer']) }}>
    <i class="fa-solid fa-arrow-left mr-4" style="color: #4182f6;"></i>
    @if($selectedCategory['name'] !== 'MyScarlet')
        <i class="fa-solid fa-{{$fa_icons[$selectedCategory['name']]}}" style="color: #4182f6;"></i>
    @else
        <img src="/logo/scarlet.svg"/>
    @endif
    <div class="text-xl underline ml-1" style="color: #4182f6;">{{ $selectedCategory['name'] }}</div>
</div>
<div class="mt-4">
    <div class="my-4 text-xl">{{ $selectedTemplate['title'] }}</div>
    <textarea class="w-full h-[40rem] p-4 bg-white border-transparent"
              disabled>{{ $selectedTemplate['template_var'] }}</textarea>
    <div class="mt-4 flex">
        <x-button @click="openSidebar = false; useTemplate()" onclick="useTranslation()"
                  class="!bg-blue-500 hover:!bg-white hover:text-blue-500 hover:border-blue-500">Use this template
        </x-button>
        <x-button
            class="ml-auto !bg-white !text-blue-500 !border-blue-500 hover:!bg-blue-500 hover:!text-white hover:border-blue-500"
            onclick="copyToClipboard('selectedTemplate')">Copy template
        </x-button>
    </div>
    <div id="selectedTemplate" class="hidden">{{ $selectedTemplate['template_var'] }}</div>
</div>
