<script>
import { Button } from '@/components/ui/button/index.js'
import LoginForm from "@/components/auth/LoginForm.vue";

export default {
  components: {
    LoginForm,
    Button,
  },
  methods: {
    async goToRegister() {
      try {
        await this.$router.push('/register');
      } catch (error) {
        console.error('An error occurred while navigating to login page:', error);
      }
    }
  },
};
</script>

<template>
  <div class="container relative hidden h-[600px] flex-col items-center justify-center md:grid lg:max-w-none lg:grid-cols-1 lg:px-0">
    <Button class="absolute right-4 top-4 md:right-8 md:top-8" variant="ghost"  @click="goToRegister">
      Create an account
    </Button>
    <div class="lg:p-8">
      <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
        <div class="flex flex-col space-y-2 text-center">
          <h1 class="text-2xl font-semibold tracking-tight">
            Login
          </h1>
          <p class="text-sm text-muted-foreground">
            Enter your email and password below to login
          </p>
        </div>
        <LoginForm />
      </div>
    </div>
  </div>
</template>
