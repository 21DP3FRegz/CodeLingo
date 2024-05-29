<script>
import api from '@/api.js';

export default {
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      course: null,
      currentLessonId: null, // ID текущего урока
      progress: 0, // Прогресс пользователя в курсе
    };
  },
  async created() {
    await this.fetchCourse();
    await this.fetchUserProgress();
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
        const response = await api.get(`/user_courses/${this.id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        const userCourse = response.data;
        this.progress = userCourse.progress;
        this.setCurrentLesson();
      } catch (error) {
        console.error('Failed to fetch user progress:', error);
      }
    },
    setCurrentLesson() {
      const currentLesson = this.course.lessons.find(lesson => lesson.order === this.progress);
      this.currentLessonId = currentLesson ? currentLesson.id : null;
    },
    isLessonAccessible(order) {
      return order <= this.progress;
    },
    viewLesson(lessonId) {
      this.$router.push(`/lessons/${lessonId}`);
    },
    goBack() {
      this.$router.push('/');
    },
  },
};
</script>

<template>
  <div>
    <h2>{{ course.course_name }}</h2>
    <p>{{ course.description }}</p>
    <h3>Lessons</h3>
    <ul>
      <li v-for="lesson in course.lessons" :key="lesson.id">
        <h4 :class="{ current: lesson.id === currentLessonId }">{{ lesson.title }}</h4>
        <button @click="viewLesson(lesson.id)" :disabled="!isLessonAccessible(lesson.order)-1">
          {{ lesson.id === currentLessonId ? 'Continue' : 'Start' }}
        </button>
      </li>
    </ul>
    <button @click="goBack">Back to Courses</button>
  </div>
</template>

<style scoped>

</style>