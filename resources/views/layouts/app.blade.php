<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Warehouse') }} </title> --}}
    <title>{{ $title ?? 'DASHBOARD' }}</title>

    <!-- Logo apps | favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/kias-logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('assets/select2.min.css') }}" rel="stylesheet" />
    <!-- Scripts -->
    <script src="{{ asset('assets/jquery.js') }}"></script>
    <script src="{{ asset('assets/select2.min.js') }}"></script>
    {{-- <script defer src="{{ asset('assets/cdn.min.js') }}"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="sidebarComponent()" x-init="initSidebar()">

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    {{-- <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg  hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button> --}}
                    <button @click="toggleSidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg  hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>

                    </button>
                    <a href="{{ route('dashboard') }}" class="flex ms-2">
                        <span
                            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Dashboard</span>
                    </a>
                    @if (isset($title))
                        <span
                            class="ms-2 self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">></span>
                        <a href="{{ route('apps-home', ['id' => $idApp]) }}">

                            <span
                                class="ms-2 self-center text-xl font-semibold sm:text-2xl @if (!isset($menuTitle)) text-blue-500 @endif whitespace-nowrap dark:text-white">
                                {{ $title }}</span>
                        </a>
                    @endif
                    @if (isset($menuTitle))
                        <span class="ms-2 self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">></span>
                        <span class="ms-2 self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">{{ $menuTitle }}</span>
                        <span class="ms-2 self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">></span>
                        <span
                            class="ms-2 self-center text-xl font-semibold sm:text-2xl text-blue-500 whitespace-nowrap">
                            {{ $subMenuTitle ?? '' }}</span>
                    @endif

                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <svg viewBox="0 0 24 24" class="w-9 h-9 rounded-full" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path opacity="0.5"
                                            d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                            fill="#1C274C"></path>
                                        <path
                                            d="M16.807 19.0112C15.4398 19.9504 13.7841 20.5 12 20.5C10.2159 20.5 8.56023 19.9503 7.193 19.0111C6.58915 18.5963 6.33109 17.8062 6.68219 17.1632C7.41001 15.8302 8.90973 15 12 15C15.0903 15 16.59 15.8303 17.3178 17.1632C17.6689 17.8062 17.4108 18.5964 16.807 19.0112Z"
                                            fill="#1C274C"></path>
                                        <path
                                            d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3432 6 9.00004 7.34315 9.00004 9C9.00004 10.6569 10.3432 12 12 12Z"
                                            fill="#1C274C"></path>
                                    </g>
                                </svg>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-200 rounded-md shadow-xl dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    <b>{{ auth()->user()->role }}</b>
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ auth()->user()->nama }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('dashboard') }}" onclick="window.__showLoader()"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Dashboard</a>
                                </li>
                                <li>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a onclick="event.preventDefault(); window.__showLoader(); this.closest('form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="button">
                                            Sign out
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="flex">

        <aside id="logo-sidebar" :class="sidebarOpen ? 'left-0 w-72' : '-left-72 w-0'"
            class="relative min-h-screen transition-all mt-16 duration-300 flex flex-col text-md font-semibold top-0 z-40  bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidebar">
            <div class="h-full px-3 py-2 overflow-y-auto bg-blue-800" x-data="{ openMenu: null }">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-2 rounded-lg  transition duration-100 text-white hover:bg-gray-100 hover:text-black group">

                            <svg viewBox="0 0 24 24"
                                class="w-6 h-6 transition duration-100 text-white  group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.27446 10.1262C5 10.7229 5 11.4018 5 12.7595V16.9999C5 18.8856 5 19.8284 5.58579 20.4142C6.11733 20.9457 6.94285 20.9949 8.5 20.9995V16C8.5 14.8954 9.39543 14 10.5 14H13.5C14.6046 14 15.5 14.8954 15.5 16V20.9995C17.0572 20.9949 17.8827 20.9457 18.4142 20.4142C19 19.8284 19 18.8856 19 16.9999V12.7595C19 11.4018 19 10.7229 18.7255 10.1262C18.4511 9.52943 17.9356 9.08763 16.9047 8.20401L15.9047 7.34687C14.0414 5.74974 13.1098 4.95117 12 4.95117C10.8902 4.95117 9.95857 5.74974 8.09525 7.34687L7.09525 8.20401C6.06437 9.08763 5.54892 9.52943 5.27446 10.1262ZM13.5 20.9999V16H10.5V20.9999H13.5Z">
                                    </path>
                                </g>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Overview </span>
                        </a>
                    </li>
                    @if (isset($menuItems))
                        @include('layouts.part.sidebar')
                    @endif

                </ul>
            </div>
        </aside>


        <div class="p-4 w-full mt-16">
            {{ $slot }}
        </div>
    </div>
    <script src="{{ asset('assets/alpine.js') }}" defer></script>
    <script>
        window.__showLoader = () => {
            const event = new CustomEvent('show-global-loader');
            window.dispatchEvent(event);
        }

        function sidebarComponent() {
            return {
                sidebarOpen: false,

                initSidebar() {
                    const saved = localStorage.getItem('sidebarOpen');
                    this.sidebarOpen = saved === 'true';
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                    localStorage.setItem('sidebarOpen', this.sidebarOpen);
                }
            };
        }
    </script>
    <div x-data="{ show: false }" x-init="window.addEventListener('show-global-loader', () => show = true);
    document.querySelectorAll('form[method=POST]:not([data-no-loading])')
        .forEach(form => form.addEventListener('submit', () => show = true));">
        <template x-if="show">
            <div x-transition.opacity.scale.duration.300ms
                class="fixed inset-0 z-50 bg-blue-400/30 backdrop-blur-md flex items-center justify-center">
                <x-loading />
            </div>
        </template>
    </div>

</body>

</html>
