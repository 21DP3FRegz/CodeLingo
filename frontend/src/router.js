import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import Register from '@/components/auth/Register.vue'
import Login from '@/components/auth/Login.vue'
import Profile from '@/components/profile/Profile.vue'
import Course from '@/components/Course.vue'
import Lesson from '@/components/Lesson.vue'
import NotFound from "@/views/NotFound.vue";
import ComingSoon from "@/views/ComingSoon.vue";
import AdminView from "@/views/AdminView.vue";
import EditCourse from "@/components/admin/EditCourse.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile
        },
        {
            path: '/logout',
            name: 'logout',
            beforeEnter(to, from, next) {
                localStorage.removeItem('token');
                localStorage.removeItem('course');
                localStorage.removeItem('userCourseId');
                next('/');
            }
        },
        {
            path: '/courses/:id',
            name: 'Course',
            component: Course,
            props: true,
        },
        {
            path: '/lessons/:id',
            name: 'Lesson',
            component: Lesson,
            props: true,
        },
        {
            path: '/leaderboard',
            name: 'leaderboard',
            component: ComingSoon,
            props: true,
        },
        {
            path: '/admin',
            name: 'admin',
            component: AdminView,
            props: true,
        },
        {
            path: '/admin/courses/edit/:id',
            name: 'EditCourse',
            component: EditCourse,
            props: true,
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'NotFound',
            component: NotFound
        },
    ]
})

export default router
