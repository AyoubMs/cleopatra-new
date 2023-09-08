@props(['id'])

<div {{ $attributes->class(['relative text-end bottom-10 right-4']) }}>
    @if($id === 'firstText')
        <i class="fa-regular fa-paste cursor-pointer" onclick="readFromClipboard('firstText')"></i>
    @elseif($id === 'inverseText')
        <i class="fa-regular fa-paste cursor-pointer" onclick="readFromClipboard('inverseText')"></i>
    @endif
</div>
