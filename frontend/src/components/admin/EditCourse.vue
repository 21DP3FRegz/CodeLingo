<template>
  <div class="relative sm:flex flex-col sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white">
  <h2 class="text-2xl font-semibold mb-4">Edit Course</h2>
    <div class="container mx-auto w-3/5 p-4 text-xl">
      <div class="w-full max-w-md">
        <CourseForm :courseId="courseId" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import CourseForm from "@/components/admin/CourseForm.vue";

const courseId = ref(null);
const router = useRouter();

onMounted(() => {
  const routeParams = router.currentRoute.value.params;
  if (routeParams.id) {
    courseId.value = routeParams.id;
  }
})
</script>