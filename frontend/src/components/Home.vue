<template>
  <div>
    <AppHeader class="sidebar" />
    <div class="main-content">
      <h1 class="title">Hello {{ name }}, Welcome to the Home Page</h1>
      <div class="card-container">
        <div v-for="item in menu" :key="item.id" class="card">
          <div class="card-header">
            <h2 class="card-title">{{ item.name }}</h2>
          </div>
          <div class="card-content">
            <p class="card-price">RM {{ item.price }}</p>
            <p class="card-description">{{ item.description }}</p>
          </div>
          <div class="card-actions">
            <button @click="navigateToUpdate(item.id)">Update</button>
            <button @click="deleteMenu(item.id)">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from './AppHeader.vue';
import axios from 'axios';

export default {
  name: 'HomePage',
  components: {
    AppHeader
  },
  data() {
    return {
      name: '',
      menu: [],
      isAdmin: false,
      orderHistory: []
    };
  },
  methods: {
    async deleteMenu(id) {
      try {
        const result = await axios.delete(`http://localhost:8000/api/menus/${id}`);
        console.log(result);
        if (result.status === 200) {
          this.loadMenu();
        }
      } catch (error) {
        console.error('Error deleting menu item:', error);
        alert('Failed to delete menu item. Please try again.');
      }
    },
    navigateToUpdate(id) {
      this.$router.push({ name: 'UpdateMenu', params: { id } });
    },
    async loadMenu() {
      try {
        let user = localStorage.getItem('user-info');
        if (user) {
          user = JSON.parse(user);
          this.name = user.name;
          this.isAdmin = user.role === 'admin';
        } else {
          this.$router.push({ name: 'SignUp' });
        }
        
        const result = await axios.get('http://localhost:8000/api/menus');
        console.log(result);
        this.menu = result.data;
      } catch (error) {
        console.error('Error loading menu:', error);
        alert('Failed to load menu items. Please refresh the page.');
      }
    },
    async updateOrderHistory(newHistory) {
      this.orderHistory = newHistory;
    }
  },
  async mounted() {
    await this.loadMenu();
  },
  activated() {
    this.loadMenu();
  }
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
  background-color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  width: calc(100% - 250px);
  height: 100vh;
  overflow: auto;
}

.title {
  font-size: 1.5em; /* Reduce font size */
  color: black;
  margin: 40px 0;
}

.card-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.card {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: calc(33.333% - 40px); /* 3 cards per row with 20px gap on each side */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-sizing: border-box;
  overflow: hidden;
  cursor: default; /* Ensure no cursor change */
}

.card-header {
  padding: 20px;
  background-color: #f2f2f2;
  display: flex;
  justify-content: center;
  align-items: center;
}

.card-logo {
  width: 50px;
  height: 50px;
}

.card-content {
  padding: 20px;
}

.card-title {
  font-size: 1.2em; /* Reduce font size */
  margin-bottom: 10px;
}

.card-price {
  color: #000;
  font-size: 1em; /* Reduce font size */
  margin-bottom: 10px;
}

.card-description {
  margin-bottom: 20px;
  font-size: 0.9em; /* Reduce font size */
}

.card-actions {
  padding: 20px;
  display: flex;
  justify-content: space-between;
}

button {
  padding: 10px;
  border: none;
  background-color: #4CAF50; /* Green */
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px; /* Reduce font size */
  cursor: pointer;
  border-radius: 4px;
}

button:hover {
  background-color: #45a049;
}

button:nth-child(2) {
  background-color: #f44336; /* Red */
}

button:nth-child(2):hover {
  background-color: #da190b;
}

/* Responsive design for smaller screens */
@media (max-width: 1024px) {
  .card {
    width: calc(50% - 40px); /* 2 cards per row with 20px gap on each side */
  }
}

@media (max-width: 768px) {
  .card {
    width: calc(100% - 40px); /* 1 card per row with 20px gap on each side */
  }
}
</style>
