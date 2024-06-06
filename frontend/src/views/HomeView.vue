<script setup>
import { ref } from 'vue';

import CourseList from "@/components/CourseList.vue";
import Footer from "@/components/Footer.vue";
import {Button} from "@/components/ui/button/index.js";
import {Cross1Icon} from "@radix-icons/vue";

const hasToken = ref(localStorage.getItem('token'));
</script>

<template>
  <main>
    <div
        v-if="!hasToken"
        class="relative sm:flex flex-col sm:justify-center sm:items-center min-h-screen bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
      <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center items-center text-center m-6">
          <img src="../../public/guy-w.png" alt="">
          <div class="flex items-center flex-col">

                    <span class="mb-4 font-semibold text-5xl text-gray-800 leading-tight">
                        The free, fun, and effective way to learn a code!
                    </span>

            <router-link to="/register">
              <Button class="mt-4 w-64">
                Get Started
              </Button>
            </router-link>

            <router-link to="/login">
              <Button variant="outline" class="mt-4 w-64">
                I Already Have An Account
              </Button>
            </router-link>

          </div>
        </div>
      </div>
    </div>
    <CourseList/>
  </main>
  <Footer v-if="hasToken"/>
</template>
