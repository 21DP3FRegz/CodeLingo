<script>
import api from '@/api.js';

export default {
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      message: '',
      error: false,
    };
  },
  methods: {
    async login() {
      try {
        const response = await api.post('/login', this.form);
        localStorage.setItem('token', response.data.token);
        this.message = 'Login successful!';
        this.error = false;
        this.$router.push('/profile');
      } catch (error) {
        this.message = error.response.data.message || 'Login failed';
        this.error = true;
      }
    },
  },
};
</script>

<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email:</label>
        <input v-model="form.email" type="email" id="email" />
      </div>
      <div>
        <label for="password">Password:</label>
        <input v-model="form.password" type="password" id="password" />
      </div>
      <button type="submit">Login</button>
    </form>
    <div v-if="message" :class="{'error': error}">
      {{ message }}
    </div>
  </div>
</template>

<style>
.error {
  color: red;
}
</style>
