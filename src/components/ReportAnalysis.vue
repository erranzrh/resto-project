<template>
    <div>
      <AppHeader />
      <div class="container">
        <h1>Report Analysis Page</h1>
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
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import AppHeader from './AppHeader.vue';
  import axios from 'axios';
  
  export default {
    name: 'ReportAnalysis',
    components: {
      AppHeader,
    },
    data() {
      return {
        name: '',
        userCount: 0,
        menuCount: 0,
      };
    },
    methods: {
      async loadData() {
        let user = localStorage.getItem('user-info');
        if (!user) {
          this.$router.push({ name: 'SignUp' });
          return;
        }
        this.name = JSON.parse(user).name;
  
        let menuResult = await axios.get('http://localhost:3000/menu');
        let userResult = await axios.get('http://localhost:3000/user');
  
        this.userCount = userResult.data.length;
        this.menuCount = menuResult.data.length;
      },
    },
    async mounted() {
      this.loadData();
    },
  };
  </script>
  
  <style>
  .container {
    padding: 40px;
  }
  
  .stats-container {
    display: flex;
    justify-content: space-around;
    margin-bottom: 40px;
  }
  
  .stat-card {
    background-color: #ffa726;
    padding: 40px;
    border-radius: 8px;
    width: 200px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
  