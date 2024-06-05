<script>
import { Button } from '@/components/ui/button'

export default {
  components: {
    Button,
  },
  methods: {
    async goHome() {
      try {
        await this.$router.push('/');
      } catch (error) {
        console.error('An error occurred while navigating to login page:', error);
      }
    }
  },
};
</script>

<template>
  <body class="flex flex-col h-screen justify-center items-center bg-gray-100">
    <div class="flex flex-col items-center">
      <h1 class="text-[120px] font-extrabold text-gray-700">404</h1>
      <p class="text-2xl font-medium text-gray-600 mb-6">Page Not Found</p>
      <Button @click="goHome" class="px-8 py-2 m-4">
        Go Home
      </Button>
    </div>
  </body>
</template>
