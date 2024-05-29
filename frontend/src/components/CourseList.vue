<script>
import api from '@/api.js';
import AuthPrompt from '@/components/AuthPrompt.vue';


export default {
  components: {
    AuthPrompt,
  },
  data() {
    return {
      courses: [],
      userCourses: [],
      showAuthPrompt: false,
    };
  },
  async created() {
    await this.fetchCourses();
    await this.fetchUserCourses();
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
    async fetchUserCourses() {
      try {
        const token = localStorage.getItem('token');
        const response = await api.get('/user_courses', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.userCourses = response.data;
      } catch (error) {
        console.error('Failed to fetch user courses:', error);
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
        await this.fetchUserCourses(); // обновить список курсов пользователя
      } catch (error) {
        if (error.response && error.response.status === 401) {
          this.showAuthPrompt = true;
        } else {
          console.error('Failed to start course:', error);
        }
      }
    },
    viewCourse(id) {
      this.$router.push(`/courses/${id}`);
    },
    isCourseStarted(courseId) {
      return this.userCourses.some(userCourse => userCourse.course_id === courseId);
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
        <button v-if="!isCourseStarted(course.id)" @click="startCourse(course)">Start Course</button>
        <button v-else @click="viewCourse(course.id)">View Course</button>
      </li>
    </ul>
    <AuthPrompt v-if="showAuthPrompt" />
  </div>
</template>

<style scoped>

</style>