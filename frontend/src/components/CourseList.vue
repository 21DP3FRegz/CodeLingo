<script>
import api from '@/api.js';
import AuthPrompt from '@/components/AuthPrompt.vue';

export default {
  components: {AuthPrompt},
  data() {
    return {
      courses: [],
      showAuthPrompt: false,
    };
  },
  async created() {
    await this.fetchCourses();
  },
  methods: {
    async fetchCourses() {
      try {
        const response = await api.get('/courses');
        this.courses = response.data;
      } catch (error) {
        console.error('Failed to fetch courses:', error);
      }
    },
    async startCourse(course) {
      try {
        const token = localStorage.getItem('token');
        const response = await api.post('/user_courses', {
          course_id: course.id,
          progress: 0,
        }, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        alert('Course started successfully!');
      } catch (error) {
        if (error.response.status === 401) {
          this.showAuthPrompt = true;
        } else {
          console.error('Failed to start course:', error);
        }
      }
    },
  },
};
</script>

<template>
  <div>
    <h2>Available Courses</h2>
    <ul>
      <li v-for="course in courses" :key="course.id">
        <h3>{{ course.course_name }}</h3>
        <p>{{ course.description }}</p>
        <button @click="startCourse(course)">Start Course</button>
      </li>
    </ul>
    <AuthPrompt v-if="showAuthPrompt" />
  </div>
</template>

<style scoped>

</style>