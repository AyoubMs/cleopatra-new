@props([
    'sortField',
    'sortAsc',
    'field'
])

@if($sortField !== $field)
    <span {{ $attributes }}></span>
@elseif($sortAsc)
    <span><i class="fa-solid fa-chevron-up ml-2 text-xs"></i></span>
@else
    <span><i class="fa-solid fa-chevron-down ml-2 text-xs"></i></span>
@endif
