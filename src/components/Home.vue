<template>
    <div>
      <AppHeader />
      <div>
        <h1>Hello {{ name }}, Welcome to the Home Page</h1>
        <div class="table-container">
          <table border="1px">
            <thead>
              <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in menu" :key="item.id">
                <td>{{ item.name }}</td>
                <td>RM {{ item.price }}</td>
                <td>{{ item.description }}</td>
                <td>
                  <router-link :to="'/update-menu/' + item.id">
                    <button class="update-button">Update</button>
                  </router-link>
                  <button class="delete-button" @click="deleteRestaurant(item.id)">Delete</button>
                </td>
              </tr>
            </tbody>
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
    data() {
      return {
        name: '',
        menu: [],
      };
    },
    components: {
      AppHeader,
    },
    methods: {
      async deleteRestaurant(id) {
        let result = await axios.delete('http://localhost:3000/menu/' + id);
        console.warn(result);
        if (result.status == 200) {
          this.loadData();
        }
      },
      async loadData() {
        let user = localStorage.getItem('user-info');
        if (!user) {
          this.$router.push({ name: 'SignUp' });
          return;
        }
        this.name = JSON.parse(user).name;
  
        let result = await axios.get('http://localhost:3000/menu');
        console.warn(result);
        this.menu = result.data;
      },
    },
    async mounted() {
      this.loadData();
    },
  };
  </script>
  
  <style>
  .table-container {
    display: flex;
    justify-content: center;
  }
  
  table {
    border-collapse: collapse;
    width: 80%;
    margin-top: 20px;
  }
  
  thead th {
    background-color: #f2f2f2;
  }
  
  td, th {
    text-align: left;
    padding: 12px;
  }
  
  tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
  }
  
  tbody tr:hover {
    background-color: #f1f1f1;
  }
  
  button {
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
  }
  
  .update-button {
    background-color: #007bff;
    color: white;
    margin-right: 5px;
  }
  
  .update-button:hover {
    background-color: #0056b3;
  }
  
  .delete-button {
    background-color: #dc3545;
    color: white;
  }
  
  .delete-button:hover {
    background-color: #c82333;
  }
  </style>
  