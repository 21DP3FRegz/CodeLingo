<script>
import api from '@/api.js';

export default {
  data() {
    return {
      form: null,
    };
  },

  async created() {
    await this.fetchUserData();
  },

  methods: {
    async fetchUserData() {
      try {
        const token = localStorage.getItem('token');
        const response = await api.get('/user', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.form = response.data;
      } catch (error) {
        console.error('Failed to fetch user data:', error);
      }
    },

    async updateProfile() {
      try {
        const token = localStorage.getItem('token');
        await api.put('/user', this.form, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        alert('Profile updated successfully!');
      } catch (error) {
        console.error('Failed to update profile:', error);
      }
    },

    async logout() {
      localStorage.removeItem('token');
      this.$router.push('/');
    },
  },
};
</script>

<template>
  <div>
    <h2>Profile</h2>
    <div v-if="form">
      <form @submit.prevent="updateProfile">
        <div>
          <label for="name">Name:</label>
          <input v-model="form.name" type="text" id="name" />
        </div>
        <div>
          <label for="email">Email:</label>
          <input v-model="form.email" type="email" id="email" />
        </div>
        <button type="submit">Update Profile</button>
      </form>
      <button @click="logout">Logout</button>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>
  </div>
</template>

<style scoped>

</style>