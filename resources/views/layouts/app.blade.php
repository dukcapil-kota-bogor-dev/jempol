<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/Logo Dukcapil.png') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900" x-data="{ open: false }">
        <div class="flex h-screen overflow-hidden bg-gray-100">
            
            <div x-show="open" 
                 @click="open = false" 
                 class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 md:hidden"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            <aside :class="{'translate-x-0': open, '-translate-x-full': !open}"
                   class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-md transition-transform duration-300 ease-in-out transform md:relative md:translate-x-0 flex-shrink-0 border-r border-gray-200">
                @include('layouts.navigation')
            </aside>

            <div class="flex-1 flex flex-col overflow-y-auto no-scrollbar">
                
                <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
                    <div class="flex items-center justify-between h-20 px-4 sm:px-6 lg:px-8">
                        
                        <div class="flex items-center gap-4">
                            <button @click="open = !open" class="text-gray-500 md:hidden focus:outline-none">
                                <i class="fa-solid fa-bars text-xl"></i>
                            </button>

                            <h2 class="font-bold text-xl text-gray-800 tracking-tight">
                                @isset($header)
                                    {{ $header }}
                                @endisset
                            </h2>
                        </div>

                        <div class="flex items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white focus:outline-none transition ease-in-out duration-150">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center mr-2 border border-gray-200">
                                                <i class="fa-solid fa-user text-gray-400 text-xs"></i>
                                            </div>
                                            <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                                        </div>
                                        <div class="ms-2">
                                            <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-red-600 font-medium">
                                            <div class="flex items-center">
                                                <i class="fa-solid fa-right-from-bracket mr-2"></i>
                                                {{ __('Keluar Aplikasi') }}
                                            </div>
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <main class="p-6">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div> 
        </div> 

        @stack('scripts') 
    </body>
</html>