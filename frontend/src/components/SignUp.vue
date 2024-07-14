<template>
  <div class="login-page">
    <div class="login-container">
      <div class="welcome-section">
      </div>
      <div class="login-section">
        <div class="login-form">
          <h1>Sign Up</h1>
          <p>Welcome to DineDynasty - Your Table is Ready</p>
          <div class="register">
            <input type="text" v-model="name" placeholder="Enter Name"/>
            <input type="text" v-model="email" placeholder="Enter Email"/>
            <input type="password" v-model="password" placeholder="Enter Password"/>
            <button v-on:click="signUp">Register</button>
            <p>
              <router-link to="/login">Login</router-link>
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
  name: 'SignUp',
  data() {
    return {
      name: '',
      email: '',
      password: ''
    };
  },
  methods: {
    async signUp() {
      try {
        let result = await axios.post("http://localhost:8000/api/signup", {
          name: this.name,
          email: this.email,
          password: this.password
        });

        console.warn(result);
        if (result.status === 201) {
          localStorage.setItem("user-info", JSON.stringify(result.data));
          this.$router.push({ name: 'Menu' });
        }
      } catch (error) {
        console.error("There was an error during sign-up:", error);
        alert("Sign-up failed. Please try again.");
      }
    }
  },
  mounted() {
    let user = localStorage.getItem('user-info');
    if (user) {
      this.$router.push({ name: 'Home' });
    }
  }
};
</script>

<style scoped>
.signup-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f5f5f5;
}

.signup-container {
  display: flex;
  width: 80%;
  max-width: 1200px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.signup-section {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
}

.signup-form {
  width: 100%;
  max-width: 400px;
  text-align: center;
}

.signup-form h1 {
  font-size: 2em;
  margin-bottom: 10px;
}

.signup-form p {
  margin-bottom: 20px;
  color: #666;
}

.register input {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

.register button {
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

.register button:hover {
  background-color: #ffa500;
}

.register p {
  margin-top: 20px;
  color: #666;
}

.welcome-section {
  flex: 1;
  background: url("../assets/signup.png") no-repeat center center;
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
</style>
