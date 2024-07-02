<template>
  <div class="login-container">
    <img src="../assets/DineDynasty.png" alt="Dine Dynasty Logo" />
    <h1>Login</h1>
    <div class="login">
      <input type="text" v-model="email" placeholder="Enter Email" />
      <input type="password" v-model="password" placeholder="Enter Password" />
      <button v-on:click="login">Login</button>
      <!-- <p>
        <router-link to="/sign-up">Register</router-link>
      </p> -->
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
      if (this.email === 'admin@restaurant.com' && this.password === 'admin123') {
        const adminUser = {
          name: 'Admin',
          email: this.email,
          role: 'admin'
        };
        localStorage.setItem("user-info", JSON.stringify(adminUser));
        this.$router.push({ name: 'Home' });
      } else {
        try {
          let result = await axios.get(
            `http://localhost:3000/user?email=${this.email}&password=${this.password}`
          );
          if (result.status === 200 && result.data.length > 0) {
            const customerUser = {
              ...result.data[0],
              role: 'customer'
            };
            localStorage.setItem("user-info", JSON.stringify(customerUser));
            this.$router.push({ name: 'Home' });
          } else {
            alert("Login failed. Please check your email and password.");
          }
        } catch (error) {
          console.error("There was an error during login:", error);
          alert("Login failed. Please try again.");
        }
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
.login-container {
  text-align: center;
  margin-top: 20px;
}

.login-container h1 {
  margin-top: 5px;
  margin-bottom: 0;
  font-size: 40px;
  font-weight: bold;
}

.login-container img {
  width: 500px;
}

.login {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}

.login input {
  width: 300px;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

.login button {
  width: 320px;
  padding: 10px;
  margin-top: 10px;
  border: none;
  border-radius: 5px;
  background-color: #6F5A06;
  color: white;
  font-size: 18px;
  cursor: pointer;
}

.login button:hover {
  background-color: #FAD12B;
}
</style>
