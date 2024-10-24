<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <svg class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" fill="#000000" height="200px" width="200px" version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 256 256" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="XMLID_1_" d="M9.7,9.8C9.3,9,9.6,8,10.4,7.6l12.2-6.7c0.8-0.5,1.8-0.1,2.3,0.7l4.9,8.9c18.5-5.6,39,2.4,48.6,20L54.8,43.4 c3.9,7.2,1.3,16.1-5.9,20.1c-7.2,3.9-16.2,1.3-20.1-5.9L5.1,70.5c-9.6-17.6-5.2-39.2,9.5-51.7L9.7,9.8z M176.4,253.2H256v-82.4 h-79.6V253.2z M167.3,171.4H103c-11.2,0-20.3,9.1-20.3,20.3c0,11.2,9.1,20.3,20.3,20.3h64.3V171.4z M28.6,253.2h138.6v-32.9H36.9 c-4.6,0-8.2,3.7-8.2,8.2V253.2z M78.1,187.5c0-13.6-11-24.5-24.6-24.5c-13.6,0-24.6,11-24.6,24.5C29,201,40,212,53.5,212 C67.1,212,78.1,201,78.1,187.5 M212.3,118.7l-13.8-39.4c-2.7-7.4-7.8-13.2-22.3-13.2h-63.8C97.9,66.2,92.7,72,90,79.4l-13.8,39.4 c-1,2.5-1.6,8.3,4.1,12.1l32.5,21.4c4.7,3.1,11.1,1.8,14.3-2.9c3.1-4.7,1.8-11.1-2.9-14.3l-15.6-10.3l-10.2-6.7l7.3-20h10l-5.9,16.2 l19.6,12.9c4.4,2.9,7.4,7.3,8.5,12.5c1.1,5.2,0,10.4-2.9,14.8c-1.2,1.8-2.6,3.3-4.2,4.5h27.1c-1.6-1.3-3-2.8-4.2-4.5 c-2.9-4.4-3.9-9.7-2.9-14.8c1.1-5.2,4.1-9.6,8.5-12.5l19.6-12.9L172.9,98h10l7.3,20l-10.2,6.7l-15.6,10.3c-4.7,3.1-6.1,9.5-2.9,14.3 c3.1,4.7,9.5,6.1,14.3,2.9l32.5-21.4C213.9,127,213.3,121.3,212.3,118.7 M150.6,27.6c-1.5,3.3-4.9,5.7-8.8,5.7 c-3.9,0-7.3-2.3-8.8-5.7h-17.8c-0.3,1.6-0.5,3.2-0.5,4.8c0,15,12.2,27.2,27.2,27.2c15,0,27.2-12.2,27.2-27.2c0-1.7-0.2-3.3-0.5-4.8 H150.6z M132.4,21.2c1.1-4.2,4.9-7.4,9.4-7.4c4.5,0,8.4,3.1,9.4,7.4h15.4c-4.3-9.4-13.7-16-24.7-16c-11,0-20.4,6.5-24.7,16H132.4z"></path> </g></svg>

                        {{-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" /> --}}
                    </a>
                </div>

                <!-- Navigation Links -->
               
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('bi.index')" :active="request()->routeIs('bi.index')">
                        {{ __('BI') }}
                    </x-nav-link>
                </div> --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('surgeries.index')" :active="request()->routeIs('surgeries.index')">
                        {{ __('Ciurgias') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('professionals.index')" :active="request()->routeIs('professionals.index')">
                        {{ __('Profissionais') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
             
                    <x-nav-link :href="route('relatorio.index')" :active="request()->routeIs('relatorio.index')">
                        {{ __('Relatório') }}
                    </x-nav-link>
                 
                </div>

                
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('register')">
                            {{ __('Register') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('surgeries.index')" :active="request()->routeIs('surgeries.index')">
                {{ __('Cirurgias') }}
            </x-responsive-nav-link>
        </div>
        

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
