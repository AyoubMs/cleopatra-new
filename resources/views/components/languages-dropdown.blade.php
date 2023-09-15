@props([
    'languages',
    'openLanguagesDropdown',
    /** @var \string[] */
    'lang_codes',
    /** @var \mixed */
    'templatesLanguage'
])

<div {{ $attributes->class(['w-full md:w-1/2 flex flex-col items-center mx-auto justify-end']) }}>
    <div class="w-full px-4">
        <div class="flex flex-col items-center relative">
            <div class="w-full  svelte-1l8159u">
                <div class="my-2 p-1 flex border border-gray-200 bg-white rounded svelte-1l8159u">
                    <div class="flex flex-auto flex-wrap">
                        @if($languages !== null && count((array) $languages) > 0)
                            @foreach($languages as $key=>$language)
                                <x-language :language="$language">
                                    <x-remove onclick="removeLanguage({{ $key }})"/>
                                </x-language>
                            @endforeach
                        @endif
                        <div class="flex-1">
                            <input type="text" placeholder=""
                                   class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800 rounded !border-transparent !ring-transparent">
                        </div>
                    </div>
                    <div
                            class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u">
                        <button class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none"
                                onclick="openLanguages()">
                            <i class="fa-solid fa-chevron-up text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
            @if($openLanguagesDropdown)
                <div
                        class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                    <div class="flex flex-col w-full">
                        @foreach($lang_codes as $code=>$lang)
                            @if(!in_array($lang, (array) $languages) && $code !== $templatesLanguage)
                                <x-language-element :language="$lang"
                                                    onclick="selectLanguage('{{$lang}}', {{$loop->index}})"/>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
