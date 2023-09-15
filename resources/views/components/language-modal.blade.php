@props([
    'translation',
    'templateTitle',
    'create',
    'categories',
    'templateBody'
])

div class="fixed inset-0 bg-gray-300 opacity-70"></div>

<div class="bg-white shadow-md max-w-3xl h-5/6 m-auto p-4 rounded-xl fixed inset-0">
    @if(!$translation)
        <header>
            <div class="font-bold mb-2">Title</div>
            <input type="text" placeholder="Enter a title" wire:model.live="templateTitle"
                   value="{{$templateTitle}}"
                   class="rounded w-full mb-2"/>
        </header>
    @endif

    <main>
        @if($create)
            <div class="mb-4">
                Category
                <select wire:model.live="selectedCategory" class="w-24 mt-4">
                    @foreach($categories as $category)
                        <option value={{$category->id}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="font-bold mb-1">Template</div>
        <textarea placeholder="Enter a template body" wire:model.live="templateBody"
                  class="w-full mt-2 {{$create ? 'h-[32rem]' : 'h-[36rem]'}} rounded">{{$templateBody}}</textarea>
    </main>

    <footer class="flex mt-6">
        <x-button class="mr-auto" wire:click="cancel">Cancel</x-button>
        @if($create)
            <x-button wire:click="createTemplate">Create</x-button>
        @elseif($translation)
            <x-button wire:click="updateTranslation">Update Translation</x-button>
        @else
            <x-button wire:click="update">Update</x-button>
        @endif
    </footer>
</div>
