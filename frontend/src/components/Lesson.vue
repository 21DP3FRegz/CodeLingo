<script>
import api from '@/api.js';
import Test from '@/components/Test.vue';

export default {
  components: {
    Test,
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
  <div>
    <h2>{{ lesson.title }}</h2>
    <div v-if="page === 1">
      <p>{{ lesson.content }}</p>
      <button @click="nextPage">Next</button>
    </div>
    <div v-else>
      <Test :lesson-id="lesson.id" @prev-page="prevPage" />
    </div>
  </div>
</template>

<style scoped>

</style>