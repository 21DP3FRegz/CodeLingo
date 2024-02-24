<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CourseChoise from "@/Components/CoursesChoice.vue";

defineProps({
    userCourses: {
        type: Array,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <template v-if="userCourses.length > 0">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">Have course</div>
                    </div>
                </div>
            </div>
        </template>

        <template v-else>
            <CourseChoise/>

        </template>
    </AuthenticatedLayout>
</template>
