<div>
    @if($showCategories)
        <div class="text-xs text-gray-500 mb-4">{{$selectedClient['name'] ?? ''}}</div>
        <div class="text-black-500 mb-4 text-xl">Choose a category</div>
        @foreach($categories as $category)
            <div wire:click="selectCategory({{ $category }})" class="cursor-pointer border flex flex-col py-4 justify-center shadow-lg px-8 mt-4">
                <div class="mb-2 flex items-center">
                    @if($category->name !== 'MyScarlet')
                        <i class="fa-solid fa-{{$fa_icons[$category->name]}}"></i>
                    @else
                        <img src="/logo/scarlet.svg" />
                    @endif
                    <div class="text-xl mx-4">{{ $category->name }}</div>
                </div>
                @foreach($templates as $template)
                    @if($category->name === $template->category->name)
                        <span class="text-xs">{{$template->id === 1 ? '' : ','}} {{ $template->title }}</span>
                    @endif
                @endforeach
            </div>
        @endforeach
    @elseif($showTemplates)
        <div class="text-xs text-gray-500 mb-4">{{$selectedClient['name']}} / {{$selectedCategory['name']}}</div>
        <div wire:click="returnToCategories" class="flex items-center cursor-pointer">
            <i class="fa-solid fa-arrow-left" style="color: #4182f6;"></i>
            <div class="mx-2 underline text-blue-500 text-xl">Choose a category</div>
        </div>
        <div class="mb-2 flex items-center mt-5">
            @if($selectedCategory['name'] !== 'MyScarlet')
                <i class="fa-solid fa-{{$fa_icons[$selectedCategory['name']]}}"></i>
            @else
                <img src="/logo/scarlet.svg" />
            @endif
            <div class="text-xl mx-4">{{ $selectedCategory['name'] }}</div>
        </div>
        @foreach($templates as $template)
            <div wire:click.prevent="selectTemplate({{ $template }})" class="cursor-pointer border flex flex-col py-4 justify-center shadow-lg px-8 mt-4">
                <div class="text-xl mb-4">{{ $template->title }}</div>
                <div>{!! Str::limit($template->template_html, 500) !!}</div>
            </div>
        @endforeach
    @elseif($showTemplate)
        <div wire:click="returnToTemplates" class="flex items-center cursor-pointer">
            <i class="fa-solid fa-arrow-left mr-4" style="color: #4182f6;"></i>
            @if($selectedCategory['name'] !== 'MyScarlet')
                <i class="fa-solid fa-{{$fa_icons[$selectedCategory['name']]}}" style="color: #4182f6;"></i>
            @else
                <img src="/logo/scarlet.svg" />
            @endif
            <div class="text-xl underline ml-1" style="color: #4182f6;">{{ $selectedCategory['name'] }}</div>
        </div>
        <div class="mt-4">
            <div class="my-4 text-xl">{{ $selectedTemplate['title'] }}</div>
            {!! $selectedTemplate['template_html'] !!}
            <div class="mt-4 flex">
                <x-button @click="open = false" wire:click.prevent="useTranslation" class="!bg-blue-500 hover:!bg-white hover:text-blue-500 hover:border-blue-500">Use this template</x-button>
                <x-button class="ml-auto !bg-white !text-blue-500 !border-blue-500 hover:!bg-blue-500 hover:!text-white hover:border-blue-500" onclick="copyToClipboard('selectedTemplate')">Copy template</x-button>
            </div>
            <div id="selectedTemplate" class="hidden">{{ $selectedTemplate['template_var'] }}</div>
        </div>
    @endif
</div>
