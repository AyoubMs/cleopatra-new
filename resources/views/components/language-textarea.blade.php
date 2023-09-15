@props([
    'text',
    'id' => '',
    'placeholder' => ''
])

<textarea type="text" placeholder="{{$placeholder}}" {{ $attributes->class(['w-full h-72 p-4 border-transparent']) }}
           id='{{$id}}'>{{ $text }}</textarea>
