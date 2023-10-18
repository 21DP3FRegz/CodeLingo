<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex flex-col sm:justify-center sm:items-center min-h-screen bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center items-center text-center m-6">
                <img src="../../../public/guy-w.png" alt="">
                <div class="flex items-center flex-col">

                    <span class="mb-4 font-semibold text-5xl text-gray-800 leading-tight">
                        The free, fun, and effective way to learn a code!
                    </span>

                    <Link :href="route('register')">
                        <PrimaryButton class="mt-4 w-64">
                            get started
                        </PrimaryButton>
                    </Link>

                    <Link :href="route('login')">
                        <SecondaryButton class="mt-4 w-64">
                            i already have an account
                        </SecondaryButton>
                    </Link>

                </div>
            </div>
        </div>
    </div>


    <div
        class="relative sm:flex flex-col sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-white dark:bg-gray-800 selection:bg-red-500 selection:text-white"
    >
        <span class="mb-16 font-semibold text-5xl text-gray-800 leading-tight">
            Why CodeLingo?
        </span>

        <div class="grid grid-cols-3 gap-4">
            <div class="p-4">
                <span class="font-bold text-lg">1st reason</span>
                <p class="text-gray-600">Description for the 1st reason goes here.</p>
            </div>
            <div class="p-4">
                <span class="font-bold text-lg">2nd reason</span>
                <p class="text-gray-600">Description for the 2nd reason goes here.</p>
            </div>
            <div class="p-4">
                <span class="font-bold text-lg">3rd reason</span>
                <p class="text-gray-600">Description for the 3rd reason goes here.</p>
            </div>
        </div>
    </div>


    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard')"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >Dashboard</Link
        >
        <template v-else>
            <Link
                :href="route('login')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Log in</Link
            >
            <Link
                v-if="canRegister"
                :href="route('register')"
                 class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Register</Link
            >
        </template>
    </div>

</template>

<style>

</style>
