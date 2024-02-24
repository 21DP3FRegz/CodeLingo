<script>
export default {
    data() {
        return {
            courses: []
        };
    },
    mounted() {
        this.fetchCourses();
    },
    methods: {
        fetchCourses() {
            axios.get('api/courses')
                .then(response => {
                    this.courses = response.data.courses;
                })
                .catch(error => {
                    console.error('Error fetching courses:', error);
                });
        },
        startCourse(courseId) {
            axios.post('/user-courses', {
                course_id: courseId
            })
                .then(response => {
                    console.log(response.data.message);
                })
                .catch(error => {
                    console.error('Error starting course:', error);
                });
        }
    }
};
</script>

<template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul class="p-6 text-gray-900">
                    <li v-for="course in courses" :key="course.id">
                        <div>{{ course.course_name }}</div>
                        <div>{{ course.description }}</div>
                        <button @click="startCourse(course.id)">Start Course</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>

    </div>
</template>

<style scoped>

</style>
