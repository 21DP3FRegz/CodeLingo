<script>
import api from '@/api.js';
import { Button } from '@/components/ui/button'
import { useToast } from '@/components/ui/toast/use-toast'

const { toast } = useToast()

export default {
  components: {
    Button,
  },
  data() {
    return {
      courses: [],
      userCourses: [],
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
        toast({
          description: 'Course started successfully!',
        });
        await this.fetchUserCourses();
      } catch (error) {
        if (error.response && error.response.status === 401) {
          localStorage.setItem('course', course.id);
          this.$router.push('/register');
        } else {
          console.error('Failed to start course:', error);
        }
      }
    },
    viewCourse(id) {
      localStorage.setItem('course', id);
      this.$router.push(`/courses/${id}`);
    },
    isCourseStarted(courseId) {
      return this.userCourses.some(userCourse => userCourse.course_id === courseId);
    },
  },
};
</script>

<template>
  <div
      class="relative sm:flex flex-col sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white"
  >
        <span class="m-8 font-semibold text-5xl text-gray-800 leading-tight">
            Available Courses
        </span>

    <ul class="grid grid-cols-3 gap-4">
      <li v-for="course in courses" :key="course.id" class="p-8">
        <h3 class="scroll-m-20 text-2xl font-semibold tracking-tight">
          {{ course.course_name }}
        </h3>
        <p class="leading-7 [&:not(:first-child)]:mt-6">
          {{ course.description }}
        </p>
        <Button class="mt-3" v-if="!isCourseStarted(course.id)" @click="startCourse(course)">Start Course</Button>
        <Button class="mt-3" v-else @click="viewCourse(course.id)">View Course</Button>
      </li>
    </ul>

  </div>
</template>
