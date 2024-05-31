<script>
import api from '@/api.js';

export default {
  props: {
    lessonId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      tests: [],
      answers: {},
    };
  },
  async created() {
    await this.fetchTests();
  },
  methods: {
    async fetchTests() {
      try {
        const response = await api.get('/tests', {
          params: {
            lesson_id: this.lessonId,
          },
        });
        this.tests = response.data;
      } catch (error) {
        console.error('Failed to fetch tests:', error);
      }
    },
    async submitAnswers() {
      try {
        const correctAnswers = this.tests.reduce((acc, test) => {
          if (test.correct_answer === this.answers[test.id]) {
            acc += 1;
          }
          return acc;
        }, 0);

        const score = correctAnswers / this.tests.length;
        console.log(score, this.tests.length)

        if (score === 1)
        {
          const token = localStorage.getItem('token');
          const userCourseId = localStorage.getItem('userCourseId');
          await api.put(`/user_courses/${userCourseId}`, {
            progress: this.lessonId,
          }, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.$router.push(`/courses/${this.lessonId}`);
        } else {
          console.log('lose')
          this.$router.push(`/courses/${this.lessonId}`);
        }


      } catch (error) {
        console.error('Failed to submit answers:', error);
      }
    },
  },
};
</script>

<template>
  <div>
    <h3>Tests</h3>
    <ul>
      <li v-for="(test, index) in tests" :key="index">
        <p>{{ test.question }}</p>
        <ul>
          <li v-for="(option, i) in test.options" :key="i">
            <label>
              <input type="radio" :name="'question_' + test.id" :value="i" v-model="answers[test.id]">
              {{ option }}
            </label>
          </li>
        </ul>
      </li>
    </ul>
    <button @click="$emit('prev-page')">Previous</button>
    <button @click="submitAnswers">Submit</button>
  </div>
</template>

<style scoped>

</style>