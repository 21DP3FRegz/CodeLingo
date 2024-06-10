<script>
import api from '@/api.js';
import CommunityAnswerList from './CommunityAnswerList.vue';
import router from "@/router.js";

export default {
  components: {
    CommunityAnswerList,
  },
  data() {
    return {
      question: null,
      newAnswer: {
        content: ''
      },
    };
  },
  async created() {
    await this.fetchQuestion();
  },
  methods: {
    async fetchQuestion() {
      const token = localStorage.getItem('token');
      if (!token) {
        router.push('/login');
      }
      try {
        const response = await api.get(`/questions/${this.$route.params.id}`,{
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.question = response.data;
      } catch (error) {
        console.error('Failed to fetch question:', error);
      }
    },
    async submitAnswer() {
      const token = localStorage.getItem('token');
      if (!token) {
        router.push('/login');
      }

      try {
        const response = await api.post('/answers', {
          question_id: this.question.id,
          content: this.newAnswer.content
        }, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.question.answers.push(response.data);
        this.newAnswer.content = '';
      } catch (error) {
        console.error('Failed to submit answer:', error);
      }
    }
  }
};
</script>

<template>
  <div>
    <h2>{{ question.content }}</h2>
    <p>Asked by: {{ question.user.name }}</p>
    <h3>Answers</h3>
    <community-answer-list :question-id="question.id"></community-answer-list>
    <h3>Your Answer</h3>
    <form @submit.prevent="submitAnswer">
      <textarea v-model="newAnswer.content" placeholder="Write your answer"></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
</template>

<style scoped>

</style>