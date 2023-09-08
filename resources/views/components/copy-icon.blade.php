@props(['id'])

<div {{ $attributes->class(['relative text-end bottom-10 right-4']) }}>
    @if($id === 'translatedText')
        <i class="fa-regular fa-copy cursor-pointer" onclick="copyToClipboard('translatedText')"></i>
    @elseif($id === 'inverseTranslatedText')
        <i class="fa-regular fa-copy cursor-pointer" onclick="copyToClipboard('inverseTranslatedText')"></i>
    @endif
</div>
