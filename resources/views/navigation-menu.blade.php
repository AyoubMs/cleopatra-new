<nav class="flex z-10 bg-white border-b border-gray-100 fixed h-screen border-r-2"
     :class="openSidebar ? 'w-1/3' : 'w-14'" x-cloak>
    <div class="w-14 border-r-2" x-cloak>
        <a href="{{ route('dashboard') }}">
            <x-application-mark class="block h-9"/>
        </a>
        <div class="bg-gray-100 w-1/2 mx-auto text-center">
            <a href="/dashboard">
                @if(Route::current()->uri === 'dashboard')
                    <i x-show="!openSidebar" class="fa-solid fa-language text-xl cursor-pointer" style="color: #0075ff;"></i>
                    <i x-show="openSidebar" class="fa-solid fa-language text-xl cursor-pointer"></i>
                @else
                    <i class="fa-solid fa-language text-xl cursor-pointer" style="color: #414f5e;"></i>
                @endif
            </a>
        </div>

        <div class="w-1/2 mx-auto text-center mt-4" @click="openSidebar = ! openSidebar"
             :class="openSidebar ? 'bg-gray-100' : ''">
            <i x-show="! openSidebar" class="fa-solid fa-comments text-xl cursor-pointer"></i>
            <i x-show="openSidebar" class="fa-solid fa-comments text-xl cursor-pointer"
               style="color: #0075ff;"></i>
        </div>
        @if(auth()->user()->role !== null && (Auth::user()->role->name === 'admin' or Auth::user()->role->name === 'supervisor'))
            <div class="w-1/2 mx-auto text-center mt-4">
                <a href="/templates">
                    @if(Route::current()->uri === 'templates')
                        <i x-show="!openSidebar" class="fa-solid fa-file-lines text-xl cursor-pointer" style="color: #0075ff;"></i>
                        <i x-show="openSidebar" class="fa-solid fa-file-lines text-xl cursor-pointer" ></i>
                    @else
                        <i class="fa-solid fa-file-lines text-xl cursor-pointer"></i>
                    @endif
                </a>
            </div>
            <div class="w-1/2 mx-auto text-center mt-4">
                <a href="/users" @click="users = true; templates = false">
                    @if(Route::current()->uri === 'users')
                        <i x-show="!openSidebar" class="fa-regular fa-user text-xl cursor-pointer" style="color: #0075ff;"></i>
                        <i x-show="openSidebar" class="fa-regular fa-user text-xl cursor-pointer"></i>
                    @else
                        <i class="fa-regular fa-user text-xl cursor-pointer"></i>
                    @endif
                </a>
            </div>
        @endif
        <div class="absolute top-1/2"
             :class="openSidebar ? 'text-right end-0 position-right !right-[-1.25rem]' : 'text-center start-9'">
            <i @click="openSidebar = ! openSidebar" x-show="! openSidebar"
               class="fa-solid fa-circle-chevron-right text-4xl cursor-pointer"
               style="color: #0075ff;"></i>
            <i @click="openSidebar = ! openSidebar" x-show="openSidebar"
               class="fa-solid fa-circle-chevron-left text-4xl cursor-pointer"
               style="color: #0075ff;"></i>
        </div>
        <div class="absolute bottom-7 start-1.5">
            <x-dropdown dropdown-classes="left-7 bottom-7" align="right" width="48">
                <x-slot name="trigger">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition w-8 h-8 mx-auto">
                            <img class="rounded-full object-cover" style="max-width: 40px !important;"
                                 src="{{ Auth::user()->profile_photo_url }}"
                                 alt="{{ Auth::user()->name }}"/>
                        </button>
                    @else
                        <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-cyan-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                </span>
                    @endif
                </x-slot>

                <x-slot name="content">
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Account') }}
                    </div>

                    <x-dropdown-link href="{{ route('profile.show') }}">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <div class="border-t border-gray-200"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
    <div x-show="openSidebar"
         x-transition:enter="transition duration-1000"
         x-transition:enter-start="opacity-0 scale-125"
         x-transition:enter-end="opacity-100 scale-100"
         class="w-full p-6 overflow-y-auto" x-cloak>
        @livewire('templates')
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': openSidebar, 'hidden': ! openSidebar}" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                             alt="{{ Auth::user()->name }}"/>
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')"
                                       x-cloak>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                           @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                @endif
            </div>
        </div>
    </div>
</nav>
