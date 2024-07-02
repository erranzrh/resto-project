<template>
  <div>
    <AppHeader />
    <div>
      <h1>Hello {{ name }}, Welcome to the Home Page</h1>
      <div class="table-container">
        <table border="1px">
          <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
          </tr>
          <tr v-for="item in menu" :key="item.id">
            <td>{{ item.name }}</td>
            <td>RM {{ item.price }}</td>
            <td>{{ item.description }}</td>
          </tr>
        </table>
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
    async deleteRestaurant(id) {
      try {
        const result = await axios.delete(`http://localhost:3000/menu/${id}`);
        console.log(result);
        if (result.status === 200) {
          this.loadMenu();
        }
      } catch (error) {
        console.error('Error deleting menu item:', error);
        alert('Failed to delete menu item. Please try again.');
      }
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
        
        const result = await axios.get('http://localhost:3000/menu');
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
  }
};
</script>


<style>
.table-container {
  display: flex;
  justify-content: center;
}

table {
  border-collapse: collapse;
}

td, th {
  width: 300px;
  height: 40px;
  text-align: left;
  padding: 8px;
}

th {
  background-color: #f2f2f2;
}

table, th, td {
  border: 1px solid black;
}
</style>
