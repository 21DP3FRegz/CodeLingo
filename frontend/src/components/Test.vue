<script>
import api from '@/api.js';
import Button from "@/components/ui/button/Button.vue";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'


export default {
  components: {
    Button,
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
  },
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
      currentTestIndex: 0,
      errors: [],
      showTryAgainMessage: false,
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
        // Initialize answers object with default values
        this.tests.forEach(test => {
          this.$set(this.answers, test.id, null);
        });
      } catch (error) {
        console.error('Failed to fetch tests:', error);
      }
    },
    async submitAnswer() {
      const currentTest = this.tests[this.currentTestIndex];
      const isCorrect = currentTest.correct_answer === this.answers[currentTest.id];

        if (!isCorrect) {
          this.errors.push({
            question: currentTest.question,
            correct_answer: currentTest.correct_answer,
            user_answer: this.answers[currentTest.id],
          });
        }

      if (this.currentTestIndex === this.tests.length - 1) {
        if (this.errors.length === 0) {
          const token = localStorage.getItem('token');
          const userCourseId = localStorage.getItem('userCourseId');
          await api.put(`/user_courses/${userCourseId}`, {
            progress: this.lessonId,
          }, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          const course = localStorage.getItem('course');
          this.$router.push(`/courses/${course}`);
        } else {
          this.showTryAgainMessage = true;
          console.log('!!!!!!!!')
        }
      } else {
        this.currentTestIndex++;
      }
    },
    tryAgain() {
      this.$router.go(0);
    },
    goHome() {
      this.$router.push('/');
    }
  },
};
</script>

<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div v-if="tests.length > 0" class="w-full max-w-md">
      <Card class="shadow-lg rounded-lg bg-white p-6">
        <CardHeader class="mb-4">
          <CardTitle class="text-2xl font-bold">{{ tests[currentTestIndex].question }}</CardTitle>
          <CardDescription class="text-gray-600">Choose the correct answer:</CardDescription>
        </CardHeader>
        <CardContent class="mb-4">
          <ul class="space-y-2">
            <li v-for="(option, i) in tests[currentTestIndex].options" :key="i">
              <label class="flex items-center space-x-2">
                <input type="radio" :name="'question_' + tests[currentTestIndex].id" :value="i" v-model="answers[tests[currentTestIndex].id]" class="form-radio">
                <span>{{ option }}</span>
              </label>
            </li>
          </ul>
        </CardContent>
        <CardFooter class="text-center">
          <Button @click="submitAnswer" class="">
            Submit
          </Button>
        </CardFooter>
      </Card>
    </div>
    <div v-if="showTryAgainMessage" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
      <Card class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
        <CardHeader>
          <CardTitle class="text-2xl font-bold mb-4">Error</CardTitle>
          <CardDescription>You have made {{ errors.length }} errors</CardDescription>
        </CardHeader>
        <CardContent>
          <p class="mb-6">You have made a mistake. What do you want to do next?</p>
          <ul>
            <li v-for="(error, index) in errors" :key="index" class="mb-2 text-left">
              <strong>Question:</strong> {{ error.question }}<br>
              <strong>Correct Answer:</strong> {{ tests.find(test => test.question === error.question).options[tests.find(test => test.question === error.question).correct_answer] }}<br>
              <strong>Your Answer:</strong> {{ tests.find(test => test.question === error.question).options[error.user_answer] }}
            </li>
          </ul>
        </CardContent>
        <CardFooter class="flex justify-around">
          <Button @click="tryAgain">
            Try Again
          </Button>
          <Button @click="goHome" variant="secondary">
            Go Home
          </Button>
        </CardFooter>
      </Card>

    </div>
  </div>
</template>
