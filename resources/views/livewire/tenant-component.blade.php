<div class="flex flex-col">
    Please Select a client
    <select wire:model.live="tenant" class="w-24 mt-4">
        @foreach($tenants as $tenant)
            @if($tenant)
                <option value={{$tenant->id}}>{{$tenant->name}}</option>
            @endif
        @endforeach
    </select>
    @if($tenant !== '')
        <x-button class="mt-4 !bg-blue-500 hover:!bg-white hover:text-blue-500 hover:border-blue-500" wire:click="setTenant({{$tenant->id}})">Submit</x-button>
    @endif
</div>
