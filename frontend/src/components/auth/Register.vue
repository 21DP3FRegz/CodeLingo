<script>
import { Button } from '@/components/ui/button/index.js'
import RegisterForm from "@/components/auth/RegisterForm.vue";

export default {
  components: {
    RegisterForm,
    Button,
  },
  methods: {
    async goToLogin() {
      try {
        await this.$router.push('/login');
      } catch (error) {
        console.error('An error occurred while navigating to login page:', error);
      }
    }
  },
};
</script>

<template>
  <div class="container relative hidden h-[600px] flex-col items-center justify-center md:grid lg:max-w-none lg:grid-cols-1 lg:px-0">
    <Button class="absolute right-4 top-4 md:right-8 md:top-8" variant="ghost"  @click="goToLogin">
      Login
    </Button>
    <div class="lg:p-8">
      <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
        <div class="flex flex-col space-y-2 text-center">
          <h1 class="text-2xl font-semibold tracking-tight">
            Create an account
          </h1>
          <p class="text-sm text-muted-foreground">
            Enter your email and password below to create your account
          </p>
        </div>
        <RegisterForm />
      </div>
    </div>
  </div>
</template>
