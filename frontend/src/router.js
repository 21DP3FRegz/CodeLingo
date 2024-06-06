import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import testing from '@/views/testing.vue'
import Register from '@/components/auth/Register.vue'
import Login from '@/components/auth/Login.vue'
import Profile from '@/components/profile/Profile.vue'
import Course from '@/components/Course.vue'
import Lesson from '@/components/Lesson.vue'
import NotFound from "@/views/NotFound.vue";
import CommingSoon from "@/views/CommingSoon.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/testing',
            name: 'testing',
            component: testing
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
            component: CommingSoon,
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
