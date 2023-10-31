@props([
    'lang_codes',
    'detectedSourceLang' => '',
    'value',
    'language',
    'id' => 'firstTextLanguage'
])

<select id="{{$id}}"
    {{ $attributes->class(['form-control border-transparent']) }}>
    <option value='{{$value}}'>{{$language}}</option>
    @foreach($lang_codes as $code => $lang)
        @if($detectedSourceLang === $code)
            <option selected value={{$code}}>{{ $lang }}</option>
        @elseif($code !== $value)
            <option value={{$code}}>{{ $lang }}</option>
        @endif
    @endforeach
</select>
