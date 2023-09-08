<nav class="flex z-10 bg-white border-b border-gray-100 fixed h-screen border-r-2"
     :class="open ? 'w-1/3' : 'w-14'" x-cloak>
    <div class="w-14 border-r-2" x-cloak>
        <a href="{{ route('dashboard') }}">
            <x-application-mark class="block h-9"/>
        </a>
        <div class="bg-gray-100 w-1/2 mx-auto text-center">
            <i x-show="! open" class="fa-solid fa-language text-xl cursor-pointer" style="color: #0075ff;"></i>
            <i x-show="open" class="fa-solid fa-language text-xl cursor-pointer" style="color: #414f5e;"></i>
        </div>
        <div class="w-1/2 mx-auto text-center mt-4" :class="open ? 'bg-gray-100' : ''">
            <i x-show="! open" @click="open = ! open" class="fa-solid fa-comments text-xl cursor-pointer"></i>
            <i x-show="open" @click="open = ! open" class="fa-solid fa-comments text-xl cursor-pointer"
               style="color: #0075ff;"></i>
        </div>
        <div class="absolute top-1/2" :class="open ? 'text-right end-0 position-right' : 'text-center start-12'">
            <i @click="open = ! open" x-show="! open" class="fa-solid fa-circle-chevron-right text-xl cursor-pointer"
               style="color: #0075ff;"></i>
            <i @click="open = ! open" x-show="open" class="fa-solid fa-circle-chevron-left text-xl cursor-pointer"
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
                    <!-- Teams Dropdown -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="ml-3 relative" @click.stop="">
                            <x-dropdown dropdown-classes="left-5" align="right" width="60"
                                        content-classes="absolute bottom-0 left-32 py-1 bg-white">
                                <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name ?? 'Create Team' }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                                        </svg>
                                    </button>
                                </span>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>

                                        <!-- Team Settings -->
                                        @if(! is_null(Auth::user()->currentTeam))
                                            <x-dropdown-link
                                                href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                                {{ __('Team Settings') }}
                                            </x-dropdown-link>
                                        @endif
                                        {{--Create Team--}}
{{--                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())--}}
{{--                                            <x-dropdown-link href="{{ route('teams.create') }}">--}}
{{--                                                {{ __('Create New Team') }}--}}
{{--                                            </x-dropdown-link>--}}
{{--                                        @endcan--}}

                                        <!-- Team Switcher -->
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Switch Teams') }}
                                            </div>

                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team"/>
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

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
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
         class="w-full p-6 overflow-y-scroll" x-cloak>
        @livewire('templates')
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

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
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" x-cloak>
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

                    <!-- Team Settings -->
                    @if(! is_null(Auth::user()->currentTeam))
                        <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                               :active="request()->routeIs('teams.show')" x-cloak>
                            {{ __('Team Settings') }}
                        </x-responsive-nav-link>
                    @endif
                    {{--Create Team --}}
                    {{--                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())--}}
                    {{--                        <x-responsive-nav-link href="{{ route('teams.create') }}"--}}
                    {{--                                               :active="request()->routeIs('teams.create')">--}}
                    {{--                            {{ __('Create New Team') }}--}}
                    {{--                        </x-responsive-nav-link>--}}
                    {{--                    @endcan--}}

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link"/>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
