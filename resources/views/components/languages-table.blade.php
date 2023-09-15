@props([
    /** @var \string[] */
    'lang_codes',
    'templatesLanguage',
    'languages',
    'templates'
])

<table {{ $attributes->class(['table']) }}>
    <thead>
    <tr>
        <th class="pb-6">Title</th>
        <th class="pb-6">Template ({{ $lang_codes[$templatesLanguage] }})</th>
        @if($languages !== null && count((array) $languages) > 0)
            @foreach($languages as $key=>$language)
                <th class="pb-6">Template ({{ $language }})</th>
            @endforeach
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($templates as $template)
        <tr>
            <td class="pb-6 pr-16 w-[20rem]">
                {{ $template->title }}
            </td>
            <td class="pr-8 pb-6 w-[30rem] text-center">
                <div>{{ Str::limit($template->template_var, 500) }}</div>
                <x-button onclick="selectTemplate({{ $template }})">Edit</x-button>
            </td>
            @if($languages !== null && count((array) $languages) > 0)
                @foreach($languages as $key=>$language)
                    @if($template->translations !== null)
                        @foreach((json_decode($template->translations) ?? []) as $obj)
                            @if($obj->lang === $language)
                                <td class="pr-8 pb-6 w-[30rem] text-center">
                                    <div>{{ Str::limit($obj->trans, 500) }}</div>
                                    <x-button onclick="selectTemplate({{ $template }}, '{{ $language }}')">
                                        Edit
                                    </x-button>
                                </td>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
