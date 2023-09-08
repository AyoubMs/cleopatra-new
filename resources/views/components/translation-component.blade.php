@props(['translation' => '', ''])
<div {{ $attributes->class(['w-[44rem] h-72 px-4 mb-12 mt-8']) }}>
    <x-lang-dropdown></x-lang-dropdown>
    <textarea type="text" class="w-full h-72 bg-white p-4" disabled>{{$translation}}</textarea>
</div>
