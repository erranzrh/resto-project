<template>
    <div class="menu-container">
      <AppHeader />
      <div class="menu-content">
        <h1>Menu</h1>
        <ul class="menu-list">
          <li v-for="item in menuItems" :key="item.id" class="menu-item">
            <div class="menu-info">
              <span class="menu-name">{{ item.name }}</span>
              <span class="menu-price">RM {{ item.price }}</span>
            </div>
            <button @click="addToCart(item)" class="add-to-cart">Add to Cart</button>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import AppHeader from './AppHeader.vue';
  
  export default {
    name: 'MenuPage',
    components: {
      AppHeader
    },
    data() {
      return {
        menuItems: []
      };
    },
    methods: {
      async addToCart(item) {
        let cart = localStorage.getItem('cart');
        let cartItems = cart ? JSON.parse(cart) : [];
        cartItems.push(item);
        localStorage.setItem('cart', JSON.stringify(cartItems));
        alert('Item added to cart!');
      },
      async loadMenu() {
        try {
          const response = await axios.get('http://localhost:3000/menu');
          this.menuItems = response.data;
        } catch (error) {
          console.error('Error loading menu:', error);
        }
      }
    },
    mounted() {
      this.loadMenu();
    }
  };
  </script>
  
  <style scoped>
  .menu-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .menu-content {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .menu-list {
    list-style-type: none;
    padding: 0;
  }
  
  .menu-item {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .menu-info {
    display: flex;
    align-items: center;
  }
  
  .menu-name {
    font-weight: bold;
    margin-right: 10px;
  }
  
  .menu-price {
    color: #007bff;
  }
  
  .add-to-cart {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .add-to-cart:hover {
    background-color: #218838;
  }
  </style>
  