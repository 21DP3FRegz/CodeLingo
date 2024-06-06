<script>
import api from '@/api.js';
import {CornerDownLeft, Mic, Paperclip, Eye} from "lucide-vue-next";

import {Button} from '@/components/ui/button'
import {Label} from '@/components/ui/label'
import {Textarea} from '@/components/ui/textarea'
import { Toggle } from '@/components/ui/toggle'
import {Tooltip, TooltipContent, TooltipProvider, TooltipTrigger} from '@/components/ui/tooltip'

export default {
  components: {
    CornerDownLeft,
    Paperclip,
    Mic,
    Eye,
    Button,
    Label,
    Textarea,
    Toggle,
    Tooltip, TooltipContent, TooltipProvider, TooltipTrigger,
  },
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
      await this.fetchQuestions();
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
      await this.fetchAnswers(questionId);
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
  <div class="my-8 container px-4">
    <h3 class="scroll-m-20 pb-2 text-3xl font-semibold tracking-tight transition-colors first:mt-0">Ask a Question</h3>

    <form
        @submit.prevent="submitQuestion"
        class="relative overflow-hidden rounded-lg border bg-background focus-within:ring-1 focus-within:ring-ring mb-4"
    >
      <Textarea
          v-model="newQuestion.content"
          placeholder="Type your question here..."
          class="min-h-12 resize-none border-0 p-3 shadow-none focus-visible:ring-0"
      />
      <div class="flex items-center p-3 pt-0">
        <Button type="submit" size="sm" class="ml-auto gap-1.5">
          Send
          <CornerDownLeft class="size-3.5" />
        </Button>
      </div>
    </form>

    <div class="container mx-auto px-4">
      <ul class="space-y-6 mt-10">
        <li v-for="question in questions" :key="question.id" class="border-b pb-4">
          <div class="flex justify-between items-start">
            <div>
              <p class="mb-2">{{ question.content }}</p>
              <p class="text-sm text-gray-500">Asked by: {{ question.user.name }}</p>
            </div>
            <Toggle
                variant="outline"
                aria-label="Toggle answers"
                @click="toggleAnswers(question.id)"
            >
              <Eye class="w-4 h-4" />
              Answers
            </Toggle>

          </div>
          <div v-if="question.showAnswers" class="container mx-auto px-4 mt-4">
            <ul class="space-y-2">
              <li v-for="answer in question.answers" :key="answer.id" class="border p-3 rounded-lg bg-gray-50">
                <p class="mb-2">{{ answer.content }}</p>
                <p class="text-sm text-gray-500">Answered by: {{ answer.user.name }}</p>
              </li>
            </ul>
            <form
                @submit.prevent="submitAnswer(question.id)"
                class="relative overflow-hidden rounded-lg border bg-background focus-within:ring-1 focus-within:ring-ring mt-4"
            >
              <Textarea
                  v-model="newAnswer[question.id]"
                  placeholder="Write your answer here..."
                  class="min-h-12 resize-none border-0 p-3 shadow-none focus-visible:ring-0"
              />
              <div class="flex items-center p-3 pt-0">
                <Button type="submit" size="sm" class="ml-auto gap-1.5" variant="link">
                  Reply
                  <CornerDownLeft class="size-3.5" />
                </Button>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>

</style>