<template>
    <div class="history-container">
      <AppHeader />
      <h1>Order History</h1>
      <div v-if="orders.length > 0" class="order-list">
        <ul>
          <li v-for="(order, index) in orders" :key="index" class="order-item">
            <div class="order-details">
              <div>
                <strong>Order ID:</strong> {{ order.id }}
              </div>
              <div>
                <strong>Date:</strong> {{ order.date }}
              </div>
              <div v-for="(item, idx) in order.items" :key="idx">
                {{ item.name }} - RM {{ item.price }}
              </div>
              <div>
                <strong>Total:</strong> RM {{ order.total }}
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div v-else class="empty-history">
        <p>No order history found.</p>
      </div>
    </div>
  </template>
  
  <script>
  import AppHeader from './AppHeader.vue';
  import axios from 'axios';
  
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
    methods: {
      async loadOrderHistory() {
        try {
          const user = JSON.parse(localStorage.getItem('user-info'));
          const response = await axios.get(`http://localhost:3000/orders?customer_id=${user.id}`);
          this.orders = response.data;
        } catch (error) {
          console.error('Error loading order history:', error);
        }
      }
    },
    mounted() {
      this.loadOrderHistory();
    }
  };
  </script>
  
  <style scoped>
  .history-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .order-list {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .order-item {
    margin-bottom: 10px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
  }
  
  .order-details {
    margin-bottom: 10px;
  }
  
  .empty-history {
    text-align: center;
    margin-top: 20px;
  }
  </style>
  