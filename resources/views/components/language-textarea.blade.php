@props([
    'text',
    'id' => '',
    'placeholder' => ''
])

<textarea type="text" placeholder="{{$placeholder}}" {{ $attributes->class(['w-full h-72 bg-white p-4 border-transparent']) }}
           id='{{$id}}'>{{ $text }}</textarea>
