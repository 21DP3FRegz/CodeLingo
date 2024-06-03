<template>
  <div>
    <h2>{{ course.course_name }}</h2>
    <p>{{ course.description }}</p>
    <h3>Lessons</h3>
    <ul>
      <li v-for="lesson in course.lessons" :key="lesson.id">
        <button
            @click="viewLesson(lesson.id)"
            :disabled="!isLessonAccessible(lesson.order)"
            :class="{
            current: lesson.id === currentLessonId,
            accessible: isLessonAccessible(lesson.order),
            inaccessible: !isLessonAccessible(lesson.order)
          }"
        >
          {{ lesson.title }}
        </button>
      </li>
    </ul>
    <community-chat :course-id="course.id"></community-chat>
    <button @click="goBack">Back to Courses</button>
  </div>
</template>

<script>
import api from '@/api.js';
import CommunityChat from './CommunityChat.vue';

export default {
  components: {
    CommunityChat
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
      currentLessonId: null,
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
        const response = await api.get(`/user_courses?course_id=${this.id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        const userCourse = response.data;
        this.progress = userCourse.progress;
        localStorage.setItem('userCourseId', userCourse.id);
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
      return order <= this.progress + 1;
    },
    viewLesson(lessonId) {
      if (this.isLessonAccessible(this.course.lessons.find(lesson => lesson.id === lessonId).order)) {
        this.$router.push(`/lessons/${lessonId}`);
      }
    },
    goBack() {
      this.$router.push('/');
    },
  },
};
</script>

<style scoped>
.current {
  font-weight: bold;
  color: green;
}

.accessible {
  background-color: #e0ffe0; /* Светло-зеленый фон для доступных уроков */
}

.inaccessible {
  background-color: #ffe0e0; /* Светло-красный фон для недоступных уроков */
  cursor: not-allowed; /* Курсор в виде запрета для недоступных уроков */
}
</style>