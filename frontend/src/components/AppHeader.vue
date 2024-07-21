<template>
  <div class="sidebar">
    <img src="../assets/DineDynasty.png" alt="Dine Dynasty Logo" class="logo" />
    <div v-if="username" class="welcome-message">Welcome, {{ username }}</div>
    <router-link v-if="isAdmin" to="/">Home</router-link>
    <router-link v-if="isAdmin" to="/add-menu">Add Menu</router-link>
    <router-link v-if="isAdmin" to="/notifications-page">Notification</router-link>
    <router-link v-if="!isAdmin" to="/customer-menu">List Of Menu</router-link>
    <router-link v-if="!isAdmin" to="/cart">Cart</router-link>
    <router-link v-if="!isAdmin" to="/order-history">Order History</router-link>
    <router-link v-if="isAdmin" to="/report">Report</router-link>
    <a v-on:click="logout" href="#">Logout</a>
  </div>
</template>

<script>
export default {
  name: 'AppHeader',
  data() {
    return {
      isAdmin: false,
      username: '' // Add username data property
    };
  },
  methods: {
    logout() {
      localStorage.removeItem('user-info');
      this.$router.push({ name: 'Login' });
    }
  },
  mounted() {
    let user = localStorage.getItem('user-info');
    if (user) {
      user = JSON.parse(user);
      this.isAdmin = user.role === 'admin';
      this.username = user.name; // Retrieve username from localStorage
    }
  }
};
</script>

<style>
.sidebar {
  width: 200px;
  height: 100vh;
  background-color: #FFB22C;
  color: white;
  display: flex;
  flex-direction: column;
  padding: 20px;
  align-items: center; /* Center align items */
}

.logo {
  width: 150px;
  margin-bottom: 20px; /* Add some space below the logo */
}

.welcome-message {
  margin-bottom: 20px;
  font-size: 16px; /* Adjust the font size as needed */
  font-weight: bold;
}

.sidebar a {
  color: white;
  padding: 10px;
  text-align: left;
  text-decoration: none;
  margin-bottom: 10px;
  width: 100%; /* Make links take full width */
  text-align: left; /* Center text within links */
}

.sidebar a:hover {
  background-color: #ddd;
  color: #333;
}
</style>
