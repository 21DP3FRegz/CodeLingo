<script>
import api from '@/api.js';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      message: '',
      error: false,
    };
  },
  methods: {
    async register() {
      try {
        const response = await api.post('/register', this.form);
        localStorage.setItem('token', response.data.token);
        this.message = 'Registration successful!';
        this.error = false;
        this.$router.push('/profile');
      } catch (error) {
        this.message = error.response.data.message || 'Registration failed';
        this.error = true;
      }
    },
  },
};
</script>

<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div>
        <label for="name">Name:</label>
        <input v-model="form.name" type="text" id="name" />
      </div>
      <div>
        <label for="email">Email:</label>
        <input v-model="form.email" type="email" id="email" />
      </div>
      <div>
        <label for="password">Password:</label>
        <input v-model="form.password" type="password" id="password" />
      </div>
      <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input v-model="form.password_confirmation" type="password" id="password_confirmation" />
      </div>
      <button type="submit">Register</button>
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
