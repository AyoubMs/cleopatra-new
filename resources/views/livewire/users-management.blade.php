<div class="flex flex-col mt-8" x-cloak>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block sm:px-6 lg:px-8 min-w-[30rem]">
            <div class="flex items-center justify-between">
                <div class="max-w-lg w-[16rem] lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input wire:model.live="searchTerm" id="search"
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out"
                               placeholder="Search" type="search"/>
                    </div>
                </div>
                <div>
                    <x-button onclick="createUser()">Add User</x-button>
                </div>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mt-4">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th
                                class="px-6 py-3 text-left">
                            <div class="flex items-center">
                                <button wire:click="sortBy('name')"
                                        class="bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </button>
                                <x-sort-icon field="name" :sortField="$sortField" :sortAsc="$sortAsc"/>
                            </div>
                        </th>
                        <th
                                class="px-6 py-3 text-left">
                            <div class="flex items-center">
                                <button wire:click="sortBy('email')"
                                        class="bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </button>
                                <x-sort-icon field="email" :sortField="$sortField" :sortAsc="$sortAsc"/>
                            </div>
                        </th>
                        <th
                                class="px-6 py-3 text-left">
                            <div class="flex items-center bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                            </div>
                        </th>
                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full"
                                             src="https://www.gravatar.com/avatar/?d=mp&f=y" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm leading-5 font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $user->role->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <button class="text-indigo-600 hover:text-indigo-900" onclick="editUser({{ $user }})">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <div class="h-96"></div>
    @if($edit || $create)
        <div class="fixed inset-0 bg-gray-300 opacity-70"></div>

        <div class="bg-white shadow-md max-w-3xl h-3/6 m-auto p-8 rounded-xl fixed inset-0">
            <header class="font-bold mb-4 text-3xl text-center">
                @if($edit)
                    Edit User
                @elseif($create)
                    Create User
                @endif
            </header>

            <main>
                <div class="mb-4">
                    Role
                    <select wire:model.live="selectedRole" class="p-1 w-28 mt-4 rounded">
                        @foreach($roles as $role)
                            @if(Auth::user()->role->name !== 'supervisor' and $role->name === 'admin')
                                <option value={{$role->id}}>{{$role->name}}</option>
                            @elseif($role->name !== 'admin')
                                <option value={{$role->id}}>{{$role->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="p-5">
                    <div class="font-bold mb-1">Email</div>
                    <input type="text" wire:model.live="selectedEmail" class="w-3/5 rounded {{ $edit ? 'bg-gray-300' : '' }}" />
                    @if($error)
                        <div class="text-xs">{{ $error }}</div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="font-bold mb-1">Name</div>
                    <input type="text" wire:model.live="selectedName" class="w-3/5 rounded {{ $edit ? 'bg-gray-300' : '' }}" />
                </div>
            </main>

            <footer class="flex mt-6">
                <x-button class="mr-auto" wire:click="cancel">Cancel</x-button>
                @if($create)
                    <x-button wire:click="createAndInviteUser">Invite User</x-button>
                @elseif($edit)
                    <x-button wire:click="updateUser">Update User</x-button>
                @endif
            </footer>
        </div>
    @endif
</div>
