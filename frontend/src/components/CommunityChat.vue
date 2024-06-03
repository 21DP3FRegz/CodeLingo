<script>
import api from '@/api.js';
import AuthPrompt from "@/components/AuthPrompt.vue";

export default {
  components: { AuthPrompt },
  props: {
    courseId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      questions: [],
      newQuestion: {
        course_id: this.courseId,
        content: ''
      },
      newAnswer: {}
    };
  },
  async created() {
    await this.fetchQuestions();
  },
  methods: {
    async fetchQuestions() {
      try {
        const token = localStorage.getItem('token'); // delete this
        if (!token) {
          this.showAuthPrompt = true;
        }
        const response = await api.get(`/questions?course_id=${this.courseId}`, {
          headers: {
            Authorization: `Bearer ${token}` // delete this
          }
        });
        this.questions = response.data.map(question => ({ ...question, showAnswers: false }));
      } catch (error) {
        console.error('Failed to fetch questions:', error);
      }
    },
    async submitQuestion() {
      const token = localStorage.getItem('token');
      if (!token) {
        this.showAuthPrompt = true;
      }

      try {
        const response = await api.post('/questions', {
          course_id: this.newQuestion.course_id,
          content: this.newQuestion.content
        }, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.questions.push({ ...response.data, showAnswers: false });
        this.newQuestion.content = '';
      } catch (error) {
        console.error('Failed to submit question:', error);
      }
    },
    async submitAnswer(questionId) {
      const token = localStorage.getItem('token');
      if (!token) {
        this.showAuthPrompt = true;
      }

      try {
        const response = await api.post('/answers', {
          question_id: questionId,
          content: this.newAnswer[questionId]
        }, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        const question = this.questions.find(q => q.id === questionId);
        if (question) {
          question.answers.push(response.data);
        }
        this.newAnswer[questionId] = '';
      } catch (error) {
        console.error('Failed to submit answer:', error);
      }
    },
    toggleAnswers(questionId) {
      const question = this.questions.find(q => q.id === questionId);
      if (question) {
        question.showAnswers = !question.showAnswers;
        if (question.showAnswers && !question.answers) {
          this.fetchAnswers(questionId);
        }
      }
    },
    async fetchAnswers(questionId) {
      const token = localStorage.getItem('token');
      if (!token) {
        this.showAuthPrompt = true;
      }

      try {
        const response = await api.get(`/answers?question_id=${questionId}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        const question = this.questions.find(q => q.id === questionId);
        if (question) {
          question.answers = response.data;
        }
      } catch (error) {
        console.error('Failed to fetch answers:', error);
      }
    }
  }
};
</script>

<template>
  <div>
    <h3>Ask a Question</h3>
    <form @submit.prevent="submitQuestion">
      <textarea v-model="newQuestion.content" placeholder="Ask your question"></textarea>
      <button type="submit">Submit</button>
    </form>

    <h2>Community Questions</h2>
    <ul>
      <li v-for="question in questions" :key="question.id">
        <div>
          <p>{{ question.content }}</p>
          <p>Asked by: {{ question.user.name }}</p>
          <button @click="toggleAnswers(question.id)">View Answers</button>
        </div>
        <div v-if="question.showAnswers">
          <ul>
            <li v-for="answer in question.answers" :key="answer.id">
              <p>{{ answer.content }}</p>
              <p>Answered by: {{ answer.user.name }}</p>
            </li>
          </ul>
          <form @submit.prevent="submitAnswer(question.id)">
            <textarea v-model="newAnswer[question.id]" placeholder="Write your answer"></textarea>
            <button type="submit">Reply</button>
          </form>
        </div>
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>