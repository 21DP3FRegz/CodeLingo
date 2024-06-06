<script>
import api from '@/api.js';
import Test from '@/components/Test.vue';
import Button from "@/components/ui/button/Button.vue";

export default {
  components: {
    Test,
    Button,
  },
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      lesson: null,
      page: 1,
    };
  },
  async created() {
    await this.fetchLesson();
  },
  methods: {
    async fetchLesson() {
      try {
        const response = await api.get(`/lessons/${this.id}`);
        this.lesson = response.data;
      } catch (error) {
        console.error('Failed to fetch lesson:', error);
      }
    },
    nextPage() {
      this.page++;
    },
    prevPage() {
      this.page--;
    },
  },
};
</script>

<template>
  <div class="container mx-auto px-4 py-6 h-screen" v-if="page === 1">
    <div class="bg-secondary shadow-lg rounded-lg p-6">
      <h2 class="text-2xl font-bold mb-4">{{ lesson.title }}</h2>
      <div >
        <p class="mb-6">{{ lesson.content }}</p>
        <Button @click="nextPage">
          Next
        </Button>
      </div>
    </div>
  </div>
  <div v-else>
    <Test :lesson-id="lesson.id" />
  </div>
</template>