<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <nav class="fixed top-0 left-0 z-20 w-full bg-black border-b border-gray-200 dark:bg-gray-900 dark:border-gray-600">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
            <a href="https://flowbite.com/" class="flex items-center">
                <span class="self-center text-2xl font-semibold text-white whitespace-nowrap">Tasks App</span>
            </a>
            <div class="flex md:order-2">
                <Link v-if="$page.props.auth.user" :href="route('my-tasks')"
                    class="px-4 py-2 font-semibold text-black bg-white rounded-lg hover:text-gray-900 dark:hover:text-white">
                My Tasks</Link>

                <template v-else>
                    <Link :href="route('login')"
                        class="px-4 py-2 font-semibold text-black bg-white rounded-lg hover:text-gray-900 dark:hover:text-white">
                    Log in</Link>

                    <Link :href="route('register')"
                        class="px-4 py-2 ml-4 font-semibold text-black bg-white rounded-lg hover:text-gray-900 dark:hover:text-white">
                    Register</Link>
                </template>
                <button data-collapse-toggle="navbar-sticky" type="button"
                    class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul
                    class="flex flex-col p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 md:flex-row md:space-x-8 md:mt-0 md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Upgrade to Pro</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Functions</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div>
        <div class="fixed top-0 left-0 hidden w-1/2 h-full bg-black lg:block" aria-hidden="true"></div>
        <div class="fixed top-0 right-0 hidden w-1/2 h-full bg-gray-900 lg:block" aria-hidden="true"></div>
        <slot />
    </div>
</template>
