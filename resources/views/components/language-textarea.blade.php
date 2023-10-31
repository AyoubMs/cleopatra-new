@props([
    'text',
    'id' => '',
    'placeholder' => '',
    'translateInverse' => false
])

<textarea type="text" oninput="doTranslate({{$id}})" placeholder="{{$placeholder}}" {{ $attributes->class(['w-full h-72 bg-white p-4 border-transparent']) }}
id='{{$id}}'>{{ $text }}</textarea>
