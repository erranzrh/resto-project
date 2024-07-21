<template>
    <div class="order-history">
      <AppHeader class="sidebar" />
      <div class="history-container">
        <h1 class="title">Order History</h1>
        <div class="history-content">
          <table class="order-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Menu ID</th>
                <th>Menu Name</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="order in orders" :key="order.id">
                <tr v-for="(item, index) in order.items" :key="index">
                  <td v-if="index === 0" :rowspan="order.items.length">{{ order.id }}</td>
                  <td v-if="index === 0" :rowspan="order.items.length">{{ order.order_date }}</td>
                  <td>{{ item.menu_id }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.quantity }}</td>
                </tr>
              </template>
              <tr v-if="orders.length === 0">
                <td colspan="5">No order history found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import AppHeader from './AppHeader.vue';
  
  export default {
    name: 'OrderHistory',
    components: {
      AppHeader
    },
    data() {
      return {
        orders: []
      };
    },
    async mounted() {
      const user = JSON.parse(localStorage.getItem('user-info'));
      if (user) {
        try {
          const response = await axios.get(`http://localhost:8000/api/orders?user_id=${user.id}`);
          console.log(response.data);  // Debugging output
          this.orders = response.data;
        } catch (error) {
          console.error('Error fetching order history:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .order-history {
    display: flex;
  }
  
  .sidebar {
    width: 250px;
    background-color: #FFB22C;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
  }
  
  .history-container {
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
  
  .history-content {
    width: 100%;
    max-width: 1200px;
  }
  
  .order-details {
    margin-bottom: 20px;
  }
  
  .order-items {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
  }
  
  .order-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .order-table th,
  .order-table td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    text-align: left;
  }
  
  .empty-history {
    text-align: center;
    margin-top: 20px;
  }
  </style>
  