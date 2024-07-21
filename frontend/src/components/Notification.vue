<template>
    <div class="notifications-page">
      <AppHeader class="sidebar" />
      <div class="notifications-container">
        <h1 class="title">Admin Notifications</h1>
        <div class="search-container">
          <input
            type="text"
            v-model="searchQuery"
            placeholder="Search by menu name..."
            class="search-input"
          />
        </div>
        <div class="notifications-content">
          <div
            v-for="order in filteredOrders"
            :key="order.order_id"
            class="notification-card"
          >
            <h2>Order ID: {{ order.order_id }}</h2>
            <p><strong>User:</strong> {{ order.user_name }}</p>
            <div class="items">
              <p><strong>Items:</strong></p>
              <ul>
                <li v-for="item in order.items" :key="item.id">
                  {{ item.name }} (Quantity: {{ item.quantity }}, Price: RM
                  {{ item.price }})
                </li>
              </ul>
            </div>
          </div>
          <div v-if="filteredOrders.length === 0" class="empty-notifications">
            <p>No notifications found.</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import AppHeader from './AppHeader.vue';
  
  export default {
    name: 'AdminNotifications',
    components: {
      AppHeader,
    },
    data() {
      return {
        orders: [],
        searchQuery: '',
      };
    },
    computed: {
      filteredOrders() {
        if (!this.searchQuery) {
          return this.orders;
        }
        return this.orders.filter((order) =>
          order.items.some((item) =>
            item.name.toLowerCase().includes(this.searchQuery.toLowerCase())
          )
        );
      },
    },
    async mounted() {
      try {
        const response = await axios.get(
          'http://localhost:8000/api/admin/notifications'
        );
        this.orders = response.data;
      } catch (error) {
        console.error('Error fetching notifications:', error);
      }
    },
  };
  </script>
  
  <style scoped>
  .notifications-page {
    display: flex;
  }
  
  .sidebar {
    width: 250px;
    background-color: #ffb22c;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
  }
  
  .notifications-container {
    margin-left: 250px;
    flex-grow: 1;
    padding: 40px;
    background-color: #f5f5f5;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .title {
    font-size: 2em;
    margin-bottom: 20px;
  }
  
  .search-container {
    margin-bottom: 20px;
    width: 100%;
    max-width: 800px;
  }
  
  .search-input {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
  }
  
  .notifications-content {
    width: 100%;
    max-width: 800px;
  }
  
  .notification-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
  }
  
  .notification-card h2 {
    margin: 0 0 10px;
  }
  
  .notification-card p {
    margin: 5px 0;
  }
  
  .items ul {
    list-style: none;
    padding: 0;
  }
  
  .items ul li {
    margin-bottom: 5px;
  }
  
  .empty-notifications {
    text-align: center;
    margin-top: 20px;
  }
  </style>
  