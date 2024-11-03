<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

let menu = ref(false)

const showMenu = () => {
    menu.value = !menu.value
}
</script>

<template>
    <nav class="fixed top-0 left-0 z-20 w-full bg-white border-b border-gray-200">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
            <a href="https://flowbite.com/" class="flex items-center">
                <span class="self-center text-xl font-semibold text-black lg:text-2xl whitespace-nowrap">Tasks App</span>
            </a>
            <div class="flex gap-2 md:order-2">
                <Link v-if="$page.props.auth.user" :href="route('my-tasks')"
                    class="hidden px-4 py-2 font-semibold text-white bg-black rounded-lg lg:block">
                My Tasks</Link>

                <template v-else>
                    <Link :href="route('login')"
                        class="hidden px-4 py-2 font-semibold text-white bg-black rounded-lg lg:block">
                    Log in</Link>

                    <Link :href="route('register')"
                        class="hidden px-4 py-2 font-semibold text-white bg-black rounded-lg lg:block">
                    Register</Link>
                </template>
                <button @click="showMenu" data-collapse-toggle="navbar-sticky" type="button"
                    class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-black rounded-lg md:hidden"
                    aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div :class="{ 'md:block': menu, 'hidden md:block': !menu }" class="w-full md:w-auto" id="navbar-sticky">
                <ul
                    class="flex flex-col p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 md:flex-row md:space-x-8 md:mt-0 md:border-0">
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-black rounded md:bg-transparent md:text-blue-700 md:p-0"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-black rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0">Upgrade
                            to Pro</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-black rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0">Services</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 pl-3 pr-4 text-black rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0">Functions</a>
                    </li>
                    <li v-if="$page.props.auth.user" class="lg:hidden">
                        <Link :href="route('my-tasks')"
                            class="block py-2 pl-3 pr-4 text-black bg-white rounded-md md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500">
                        My Tasks</Link>
                    </li>
                    <template v-else>
                        <li class="mt-2 lg:hidden">
                            <Link :href="route('login')"
                                class="block py-2 pl-3 pr-4 text-black bg-white rounded-md md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500">
                            Log in</Link>
                        </li>
                        <li class="mt-2 lg:hidden">
                            <Link :href="route('register')"
                                class="block py-2 pl-3 pr-4 text-black bg-white rounded-md md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500">
                            Register</Link>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>

    <div>
        <!--
            <div class="fixed top-0 left-0 hidden w-1/2 h-full bg-black lg:block" aria-hidden="true"></div>
            <div class="fixed top-0 right-0 hidden w-1/2 h-full bg-gray-900 lg:block" aria-hidden="true"></div>
            -->
        <slot />
    </div>
</template>
