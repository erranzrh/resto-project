<template>
  <div>
    <AppHeader class="sidebar" />
    <div class="main-content">
      <h1>Admin Dashboard</h1>
      <div class="stats-container">
        <div class="stat-card">
          <img src="@/assets/user.png" alt="Total Users" class="stat-image"/>
          <h2>Total Users</h2>
          <p>{{ userCount }}</p>
        </div>
        <div class="stat-card">
          <img src="@/assets/menu.png" alt="Total Menu Items" class="stat-image"/>
          <h2>Total Menu Items</h2>
          <p>{{ menuCount }}</p>
        </div>
        <div class="stat-card">
          <img src="@/assets/orders.png" alt="Total Orders" class="stat-image"/>
          <h2>Total Orders</h2>
          <p>{{ orderCount }}</p>
        </div>
        <div class="stat-card">
          <img src="@/assets/revenue.png" alt="Total Revenue" class="stat-image"/>
          <h2>Total Revenue</h2>
          <p>RM {{ totalRevenue }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from './AppHeader.vue';
import axios from 'axios';

export default {
  name: 'AdminDashboard',
  components: {
    AppHeader,
  },
  data() {
    return {
      userCount: 0,
      menuCount: 0,
      orderCount: 0,
      totalRevenue: 0,
    };
  },
  methods: {
    async loadData() {
      try {
        // Fetch statistics from backend
        const [userResponse, menuResponse, orderResponse, revenueResponse] = await Promise.all([
          axios.get('http://localhost:3000/user'),
          axios.get('http://localhost:8000/api/menus'),
          axios.get('http://localhost:3000/orders'),
          axios.get('http://localhost:3000/orders/total-revenue'),
        ]);

        // Update data
        this.userCount = userResponse.data.length;
        this.menuCount = menuResponse.data.length;
        this.orderCount = orderResponse.data.length;
        this.totalRevenue = revenueResponse.data.totalRevenue; // Assuming the backend returns total revenue
      } catch (error) {
        console.error('Error loading data:', error);
      }
    },
  },
  mounted() {
    this.loadData();
  },
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html, body, #app {
  height: 100%;
}

.sidebar {
  width: 250px;
  height: 100vh;
  background-color: #FFB22C;
  color: white;
  display: flex;
  flex-direction: column;
  padding: 20px;
  position: fixed;
  left: 0;
  top: 0;
}

.main-content {
  margin-left: 250px;
  padding: 40px;
  width: calc(100% - 250px);
  height: 100vh;
  overflow: auto;
}

.stats-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 2 cards per row */
  gap: 80px;
  justify-items: center;
  margin-top: 20px;
}

.stat-card {
  background-color: #4caf50;
  padding: 40px;
  border-radius: 8px;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 100%; /* Ensure all cards take full width of the grid cell */
  max-width: 400px; /* Set a max-width to make them look uniform */
  box-sizing: border-box; /* Ensure padding and border are included in the width */
}

.stat-image {
  width: 60px;
  height: 60px;
  margin-bottom: 10px;
}

.stat-card h2 {
  margin: 0;
  font-size: 18px;
  color: #fff;
}

.stat-card p {
  margin: 5px 0 0;
  font-size: 24px;
  font-weight: bold;
  color: #fff;
}
</style>
