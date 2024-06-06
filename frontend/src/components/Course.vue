<script>
import api from '@/api.js';

import { LockClosedIcon } from '@radix-icons/vue'
import CommunityChat from './CommunityChat.vue';
import Footer from "@/components/Footer.vue";
import Button from "@/components/ui/button/Button.vue";
import { useToast } from '@/components/ui/toast/use-toast'

const { toast } = useToast()

export default {
  components: {
    Button,
    Footer,
    CommunityChat,
    LockClosedIcon
  },
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      course: null,
      progress: 0,
    };
  },
  async created() {
    await this.fetchCourse();
    await this.fetchUserProgress();
    console.log(this.progress)
  },
  methods: {
    async fetchCourse() {
      try {
        const response = await api.get(`/courses/${this.id}`);
        this.course = response.data;
      } catch (error) {
        console.error('Failed to fetch course:', error);
      }
    },
    async fetchUserProgress() {
      try {
        const token = localStorage.getItem('token');
        const response = await api.get(`/user_courses?course_id=${this.course.id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        const userCourse = response.data;
        if (!userCourse.id) {
          await this.startCourse();
        } else {
          this.progress = userCourse.progress;
          localStorage.setItem('userCourseId', userCourse.id);
        }
      } catch (error) {
        console.error('Failed to fetch user progress:', error);
      }
    },
    async startCourse() {
      const token = localStorage.getItem('token');
      const response = await api.post('/user_courses', {
        course_id: this.course.id,
        progress: 0,
      }, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      toast({
        description: 'Course started successfully!',
      });
      await this.fetchUserProgress();
    },
    isLessonAccessible(order) {
      return order <= this.progress + 1;
    },
    viewLesson(lessonId) {
      if (this.isLessonAccessible(this.course.lessons.find(lesson => lesson.id === lessonId).order)) {
        this.$router.push(`/lessons/${lessonId}`);
      }
    },
  },
};
</script>

<template>
  <div class="container mx-auto px-4">
    <h2 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">{{ course.course_name }}</h2>
    <p class="leading-7 [&:not(:first-child)]:mt-6">{{ course.description }}</p>
    <h3 class="mt-10 scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight transition-colors first:mt-0">Lessons</h3>
    <ul class="space-y-4">
      <li v-for="lesson in course.lessons" :key="lesson.id" class="shadow-lg p-4 rounded-lg bg-white">
        <button
            v-if="isLessonAccessible(lesson.order)"
            @click="viewLesson(lesson.id)"
            :class="{
              'bg-primary text-white': lesson.order === progress+1,
              'bg-white text-primary border border-primary': lesson.order !== progress+1
            }"
            class="w-full py-2 px-4 rounded-full hover:shadow-xl transition"
        >
        {{ lesson.order === progress+1 ? '' : 'Repeat: ' }}{{ lesson.title }}
        </button>
        <div v-else class="flex items-center justify-center w-full py-2 px-4 rounded-full bg-gray-300 cursor-not-allowed"> <!-- также замените 'rounded' на 'rounded-full' -->
          <LockClosedIcon class="w-5 h-5 text-gray-600"/>
        </div>
      </li>
    </ul>
    <community-chat :course-id="course.id" class="mt-8"></community-chat>
  </div>
  <div class="mb-20"></div>
  <Footer/>
</template>