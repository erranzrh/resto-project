<template>
    <div>
      <AppHeader class="sidebar" />
      <div class="main-content">
        <h1 class="title">Hello {{ name }}, Welcome to the Add Menu Page</h1>
        <form class="addMenu">
          <input type="text" name="name" placeholder="Enter Name" v-model="menu.name" />
          <input type="text" name="price" placeholder="Enter Price" v-model="menu.price" />
          <input type="text" name="description" placeholder="Enter Description" v-model="menu.description" />
          <button type="button" v-on:click="addMenu">Add new Menu</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import AppHeader from './AppHeader.vue'
  import axios from 'axios';
  
  export default {
    name: 'AddMenu',
    components: {
      AppHeader
    },
    data() {
      return {
        name: '',
        menu: {
          name: '',
          price: '',
          description: ''
        }
      };
    },
    methods: {
      async addMenu() {
        console.warn(this.menu);
        try {
          const result = await axios.post("http://localhost:8000/api/menus", {
            name: this.menu.name,
            price: this.menu.price,
            description: this.menu.description,
          });
          if (result.status === 201) {
            this.$router.push({ name: 'Home' });
          }
          console.warn("result", result);
        } catch (error) {
          console.error("Error adding menu:", error);
        }
      }
    },
    mounted() {
      let user = localStorage.getItem('user-info');
      if (!user) {
        this.$router.push({ name: 'SignUp' });
      } else {
        try {
          this.name = JSON.parse(user).name;
        } catch (error) {
          console.error("Error parsing user-info:", error);
          this.$router.push({ name: 'SignUp' });
        }
      }
    }
  }
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
  
  .addMenu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    max-width: 500px;
    padding: 20px;
    border-radius: 8px;
  }
  
  .addMenu input {
    width: 600px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em; /* Reduce font size */
  }
  
  .addMenu button {
    padding: 10px;
    margin-top: 15px;
    border: none;
    background-color: #FFB22C; /* Green */
    color: white;
    font-size: 1em; /* Reduce font size */
    cursor: pointer;
    border-radius: 4px;
    width: 300px;
  }
  
  .addMenu button:hover {
    background-color: #FFB22C;
  }
  </style>
  