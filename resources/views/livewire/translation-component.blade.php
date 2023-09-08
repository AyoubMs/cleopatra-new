<div class="flex my-auto flex-wrap justify-center">
    <div class="w-[44rem] h-72 px-4 mb-12 mt-8">
        <div class="bg-white border-b-2 w-full h-12 flex items-center px-4" x-cloak>
            <select wire:model.live="language"
                    class="form-control {{$detectedSourceLang === null ? $languageWidths[$language] : $languageWidthsDetected[$detectedSourceLang === 'EN' ? 'EN-US' : $detectedSourceLang]}} border-transparent"
                    wire:change="translateInverse">
                <option value="none">Detect language</option>
                @foreach($lang_codes as $code => $lang)
                    @if($detectedSourceLang === $code)
                        <option selected value={{$code}}>{{ $lang }}</option>
                    @endif
                    <option value={{$code}}>{{ $lang }}</option>
                @endforeach
            </select>
            @if($detectedSourceLang !== null)
                (detected)
            @endif
        </div>
        <textarea type="text" class="w-full h-72 p-4 border-transparent" wire:model.live="firstText" wire:input.prevent.debounce.2500ms="translate" id="firstText">{{ $firstText }}</textarea>
        <x-paste-icon id="firstText"/>
    </div>
    <div class="w-[44rem] h-72 px-4 mb-12 mt-8">
        <div class="bg-white border-b-2 w-full h-12 flex items-center px-4" x-cloak>
            <select wire:model.live="targetLanguage"
                    class="form-control {{$languageWidths[$targetLanguage] ?? ''}} border-transparent"
                    wire:change="translate">
                <option value='EN-US'>English</option>
                @foreach($lang_codes as $code => $lang)
                    @if($code !== 'EN-US')
                        <option value={{$code}}>{{ $lang }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <textarea type="text" class="w-full h-72 bg-white p-4 border-transparent"
                  disabled>{{$translatedText}}</textarea>
        <x-copy-icon id="translatedText"/>
        <div id="translatedText" class="hidden">{{ $translatedText }}</div>
    </div>
    <div class="w-[44rem] h-72 px-4 mb-12 mt-8">
        <div class="bg-white border-b-2 w-full h-12 flex items-center px-4" x-cloak>
            {{ $lang_codes[$targetLanguage] }}
        </div>
        <textarea type="text" class="w-full h-72 bg-white p-4 border-transparent" wire:model.live="inverseText"
                  wire:input.prevent.debounce.2500ms="translateInverse" placeholder="Choose a template or start typing to translate...">{{ $inverseText }}</textarea>
        <x-paste-icon id="inverseText"/>
        <x-button @click="open = true" wire:click="chooseATemplate" class="!bg-blue-500 hover:!bg-white hover:text-blue-500 hover:border-blue-500 relative bottom-3/4 start-60">Choose a Template</x-button>
    </div>
    <div class="w-[44rem] h-72 px-4 mb-12 mt-8">
        <div class="bg-white border-b-2 w-full h-12 flex items-center px-4" x-cloak>
            @if($language === 'none')
                {{ $detectedSourceLang !== null ? $lang_codes[$detectedSourceLang === 'EN' ? 'EN-US' : $detectedSourceLang] : 'Waiting for input...' }}
                {{ $errorMessage }}
            @else
                {{ $language !== 'none' ? $lang_codes[$language === 'EN' ? 'EN-US' : $language] : 'Waiting for input...' }}
            @endif
        </div>
        <textarea type="text" class="w-full h-72 p-4 bg-white border-transparent"
                  disabled>{{ $inverseTranslatedText }}</textarea>
        <x-copy-icon id="inverseTranslatedText" />
        <div id="inverseTranslatedText" class="hidden">{{ $inverseTranslatedText }}</div>
    </div>
</div>
