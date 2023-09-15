<div class="flex my-auto flex-wrap justify-center">
    <x-language-block>
        <x-language-selector>
            <x-select-language wire:model.live="language" wire:change="translateInverse"
                               class="{{$languageWidths[$language]}}"
                               :lang_codes="$lang_codes" :detected-source-lang="$detectedSourceLang" value="none" language="Detect Language"/>
            @if($detectedSourceLang !== null)
                (detected)
            @endif
        </x-language-selector>
        <x-language-textarea wire:model.live="firstText" wire:input.prevent.debounce.2500ms="translate" id="firstText"
                             :text="$firstText"/>
        <x-paste-icon id="firstText"/>
    </x-language-block>
    <x-language-block>
        <x-language-selector>
            <x-select-language wire:model.live="targetLanguage"
                               class="form-control {{$languageWidths[$targetLanguage] ?? ''}} border-transparent"
                               wire:change="translate(true)" value="EN-US" language="English" :lang_codes="$lang_codes"/>
        </x-language-selector>
        <x-language-textarea :text="$translatedText" disabled />
        <x-copy-icon id="translatedText"/>
        <div id="translatedText" class="hidden">{{ $translatedText }}</div>
    </x-language-block>
    <x-language-block>
        <x-language-selector>
            {{ $lang_codes[$targetLanguage] }}
        </x-language-selector>
        <x-language-textarea id="inverseText" class="w-full h-72 bg-white p-4 border-transparent" wire:model.live="inverseText"
                             wire:input.prevent.debounce.2500ms="translateInverse"
                             placeholder="Choose a template or start typing to translate..." :text="$inverseText" />

        <x-paste-icon id="inverseText"/>
        @if($inverseText === '')
            <x-button @click="open = true" wire:click="chooseATemplate"
                      class="!bg-blue-500 hover:!bg-white hover:text-blue-500 hover:border-blue-500 relative bottom-3/4 start-60">
                Choose a Template
            </x-button>
        @endif
    </x-language-block>
    <x-language-block>
        <x-language-selector>
            @if($language === 'none')
                {{ $detectedSourceLang !== null ? $lang_codes[$detectedSourceLang === 'EN' ? 'EN-US' : $detectedSourceLang] : 'Waiting for input...' }}
                {{ $errorMessage }}
            @else
                {{ $language !== 'none' ? $lang_codes[$language === 'EN' ? 'EN-US' : $language] : 'Waiting for input...' }}
            @endif
        </x-language-selector>
        <x-language-textarea :text="$inverseTranslatedText" disabled/>
        <x-copy-icon id="inverseTranslatedText"/>
        <div id="inverseTranslatedText" class="hidden">{{ $inverseTranslatedText }}</div>
    </x-language-block>
</div>
