<script>
import api from '@/api.js';

export default {
  props: {
    questionId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      answers: []
    };
  },
  async created() {
    await this.fetchAnswers();
  },
  methods: {
    async fetchAnswers() {
      try {
        const token = localStorage.getItem('token');
        if (!token) {
          this.showAuthPrompt = true;
        }
        const response = await api.get('/answers', {
          params: {
            question_id: this.questionId
          },
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.answers = response.data;
      } catch (error) {
        console.error('Failed to fetch answers:', error);
      }
    }
  }
};
</script>

<template>
  <div>
    <ul>
      <li v-for="answer in answers" :key="answer.id">
        <p>{{ answer.content }}</p>
        <p>Answered by: {{ answer.user.name }}</p>
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>