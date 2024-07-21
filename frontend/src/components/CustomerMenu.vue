<template>
  <div class="menu-container">
    <AppHeader class="sidebar" />
    <div class="menu-content">
      <h1 class="title">Menu</h1>
      <div class="card-container">
        <div v-for="item in menuItems" :key="item.id" class="card">
          <div class="card-header">
            <h2 class="card-title">{{ item.name }}</h2>
          </div>
          <div class="card-content">
            <p class="card-price">RM {{ item.price }}</p>
            <p class="card-description">{{ item.description }}</p>
          </div>
          <div class="card-actions">
            <button @click="addToCart(item)" class="add-to-cart">Add to Cart</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import AppHeader from './AppHeader.vue';

export default {
  name: 'CustomerMenu',
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
      const user = JSON.parse(localStorage.getItem('user-info'));
      if (!user) {
        alert('Please log in first.');
        return;
      }

      try {
        await axios.post('http://localhost:8000/api/cart', {
          user_id: user.id,
          menu_id: item.id,
          quantity: 1 // Default quantity
        });
        alert('Item added to cart!');
      } catch (error) {
        console.error('Error adding to cart:', error);
      }
    },
    async loadMenu() {
      try {
        const response = await axios.get('http://localhost:8000/api/menus');
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

.menu-content {
  margin-left: 250px;
  padding: 20px;
  width: calc(100% - 250px);
  background-color: #f9f9f9;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.title {
  font-size: 2em;
  margin: 20px 0;
}

.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}

.card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: calc(33.333% - 20px); /* Three cards per row with 20px gap */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow: hidden;
}

.card-header {
  padding: 20px;
  background-color: #f2f2f2;
  text-align: center;
}

.card-title {
  font-size: 1.5em;
  margin: 0;
}

.card-content {
  padding: 20px;
  flex-grow: 1;
}

.card-price {
  color: #000;
  font-size: 1.2em;
  margin: 10px 0;
}

.card-description {
  margin-bottom: 20px;
}

.card-actions {
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.add-to-cart {
  background-color: #FFB22C;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 4px;
  cursor: pointer;
  width: 150px;
}

.add-to-cart:hover {
  background-color: #FFB22C;
}

/* Responsive design */
@media (max-width: 1024px) {
  .card {
    width: calc(50% - 20px); /* Two cards per row with 20px gap */
  }
}

@media (max-width: 768px) {
  .card {
    width: 100%; /* One card per row */
  }
}
</style>
