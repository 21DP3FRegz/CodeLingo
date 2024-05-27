<script>
export default {
  methods: {
    login() {
      this.$router.push('/login');
    },
    register() {
      this.$router.push('/register');
    },
  },
};
</script>

<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <h3>You need to be logged in to start a course.</h3>
        <p>Would you like to login or create an account?</p>
        <button @click="login">Login</button>
        <button @click="register">Register</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-mask {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-wrapper {
  max-width: 400px;
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}

.modal-container {
  text-align: center;
}

button {
  margin: 0 10px;
}
</style>
