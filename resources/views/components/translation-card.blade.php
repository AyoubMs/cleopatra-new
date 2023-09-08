@props([
    'language',
    /** @var \string[] */
    'lang_codes'
])

<div {{ $attributes->class(['w-[44rem] h-72 px-4 mb-12 mt-8']) }}>
    <div x-data="{
            language: '{{$language}}',
            languageWidths: {
                'none': 'w-36',
                'BG': 'w-24',
                'CS': 'w-20',
                'DA': 'w-20',
                'DE': 'w-20',
                'EL': 'w-20',
                'EN-US': 'w-20',
                'ES': 'w-20',
                'ET': 'w-24',
                'FI': 'w-20',
                'FR': 'w-20',
                'HU': 'w-20',
                'ID': 'w-20',
                'IT': 'w-20',
                'JA': 'w-20',
                'KO': 'w-20',
                'LT': 'w-20',
                'LV': 'w-20',
                'NB': 'w-20',
                'NL': 'w-20',
                'PL': 'w-20',
                'PT': 'w-20',
                'RO': 'w-20',
                'RU': 'w-20',
                'SK': 'w-20',
                'SL': 'w-20',
                'SV': 'w-20',
                'TR': 'w-20',
                'UK': 'w-20',
                'ZH': 'w-20',
            },
            onChangeFirst(event) {
                language = event.target.value;
                console.log(languageWidths)
            }}"
         class="bg-white border-b-2 w-full h-12 flex items-center px-4" x-cloak>
        <select wire:model.live="language" class="form-control"
                :class="languageWidths[language] ? languageWidths[language] : ''"
                x-on:change="onChangeFirst" x-cloak>
            <option disabled value="none">Detect language</option>
            @foreach($lang_codes as $code => $lang)
                <option wire:key={{ $loop->index }} @selected($language === $code) value="{{$code}}">{{ $lang }}</option>
            @endforeach
        </select>
    </div>
    <textarea type="text" class="w-full h-72 p-4" wire:model="text"
              wire:input.debounce.2500ms="translate"></textarea>
</div>
