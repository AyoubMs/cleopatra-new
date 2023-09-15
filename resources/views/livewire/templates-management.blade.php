<div x-data="{ openLanguage: false }" class="flex flex-col max-w-[100rem] mx-[8rem]" x-cloak>
    <div>
        <x-languages-dropdown :languages="$languages" :openLanguagesDropdown="$openLanguagesDropdown" :lang_codes="$lang_codes" :templatesLanguage="$templatesLanguage"/>
        <x-button wire:click="createTemplate"
                  class="!bg-blue-500 !text-white hover:!bg-white hover:!text-blue-500 hover:!border-blue-500 my-6">
            Create
        </x-button>
        <x-languages-table :lang_codes="$lang_codes" :templatesLanguage="$templatesLanguage" :languages="$languages" :templates="$templates"/>
        @if($selectedTemplate !== null || $create || $translation)
            <<x-language-modal :translation="$translation" :templateTitle="$templateTitle" :create="$create" :categories="$categories" :templateBody="$templateBody"/>
        @endif
    </div>
</div>
