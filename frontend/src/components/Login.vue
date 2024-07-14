<template>
  <div class="login-page">
    <div class="login-container">
      <div class="welcome-section">
      </div>
      <div class="login-section">
        <div class="login-form">
          <h1>Login</h1>
          <p>Welcome to DineDynasty - Your Table is Ready</p>
          <div class="login">
            <input type="text" v-model="email" placeholder="Enter Email" />
            <input type="password" v-model="password" placeholder="Enter Password" />
            <button v-on:click="login">Sign In</button>
            <p>
              Don't have an account? <router-link to="/sign-up">Sign up</router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        let result = await axios.post(
          'http://localhost:8000/api/login',
          {
            email: this.email,
            password: this.password
          }
        );
        if (result.status === 200) {
          localStorage.setItem("user-info", JSON.stringify(result.data));
          const user = result.data;
          if (user.role === 'admin') {
            this.$router.push({ name: 'Home' });
          } else {
            this.$router.push({ name: 'CustomerMenu' });
          }
        } else {
          alert("Login failed. Please check your email and password.");
        }
      } catch (error) {
        console.error("There was an error during login:", error);
        alert("Login failed. Please try again.");
      }
    }
  },
  mounted() {
    let user = localStorage.getItem('user-info');
    if (user) {
      user = JSON.parse(user);
      if (user.role === 'admin') {
        this.$router.push({ name: 'Home' });
      } else {
        this.$router.push({ name: 'CustomerMenu' });
      }
    }
  }
};
</script>

<style scoped>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f5f5f5;
}

.login-container {
  display: flex;
  width: 80%;
  max-width: 1200px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.welcome-section {
  flex: 1;
  background: url("../assets/login.png") no-repeat center center;
  background-size: contain;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  padding: 40px;
}

.welcome-content {
  text-align: center;
}

.welcome-section h1 {
  font-size: 2.5em;
  margin: 0;
}

.welcome-section p {
  font-size: 1.2em;
  margin: 20px 0 0;
}

.login-section {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
}

.login-form {
  width: 100%;
  max-width: 400px;
  text-align: center;
}

.login-form h1 {
  font-size: 2em;
  margin-bottom: 10px;
}

.login-form p {
  margin-bottom: 20px;
  color: #666;
}

.login input {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

.login button {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  border: none;
  border-radius: 5px;
  background-color: #ffb22c;
  color: white;
  font-size: 18px;
  cursor: pointer;
}

.login button:hover {
  background-color: #ffa500;
}

.login p {
  margin-top: 20px;
  color: #666;
}
</style>
