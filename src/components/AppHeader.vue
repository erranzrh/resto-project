<template>
  <div class="nav">
    <router-link to="/">Home</router-link>
    <router-link v-if="isAdmin" to="/add-menu">Add Menu</router-link>
    <router-link v-if="!isAdmin" to="/menu">List Of Menu</router-link>
    <router-link v-if="!isAdmin" to="/cart">Cart</router-link>
    <router-link v-if="isAdmin" to="/report">Report</router-link>
    <!-- <router-link to="/order-history">Order History</router-link> New link for order history -->
    <a v-on:click="logout" href="#">Logout</a>
  </div>
</template>

<script>
export default {
  name: 'AppHeader',
  data() {
    return {
      isAdmin: false
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
    }
  }
};
</script>

<style>
.nav {
  background-color: #333;
  overflow: hidden;
}

.nav a {
  float: left;
  color: #f2f2f2;
  padding: 14px 14px;
  text-align: center;
  font-size: 17px;
  text-decoration: none;
  margin-right: 5px;
}

.nav a:hover {
  background-color: #ddd;
  color: #333;
}
</style>
