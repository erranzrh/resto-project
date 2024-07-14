<template>
    <div>
      <AppHeader class="sidebar" />
      <div class="main-content">
        <h1 class="title">Hello {{ name }}, Welcome to the Update Menu Page</h1>
        <form class="updateMenu">
          <input type="text" name="name" placeholder="Enter Name" v-model="menu.name" />
          <input type="text" name="price" placeholder="Enter Price" v-model="menu.price" />
          <input type="text" name="description" placeholder="Enter Description" v-model="menu.description" />
          <button type="button" v-on:click="updateMenu">Update Menu</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import AppHeader from './AppHeader.vue';
  import axios from 'axios';
  
  export default {
    name: 'UpdateMenu',
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
      async updateMenu() {
        console.log("Update button clicked");
        try {
          const result = await axios.put(`http://localhost:8000/api/menus/${this.$route.params.id}`, {
            name: this.menu.name,
            price: this.menu.price,
            description: this.menu.description,
          });
          console.log("Update result:", result);
          if (result.status === 200) {
            console.log("Update successful, redirecting...");
            this.$router.push({ name: 'Home' });
          } else {
            console.error("Update failed with status:", result.status);
          }
        } catch (error) {
          console.error("Error updating menu:", error);
        }
      }
    },
    async mounted() {
      let user = localStorage.getItem('user-info');
      if (!user) {
        this.$router.push({ name: 'SignUp' });
      } else {
        this.name = JSON.parse(user).name;
      }
  
      try {
        const result = await axios.get(`http://localhost:8000/api/menus/${this.$route.params.id}`);
        this.menu = result.data;
      } catch (error) {
        console.error("Error fetching menu item:", error);
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
  
  .updateMenu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    max-width: 500px;
    padding: 20px;
    align-items: center; /* Center align the form fields */
  }
  
  .updateMenu input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em; /* Reduce font size */
  }
  
  .updateMenu button {
    padding: 10px;
    border: none;
    background-color: #FFB22C; /* Button color */
    color: white;
    font-size: 1em; /* Reduce font size */
    cursor: pointer;
    border-radius: 4px;
    width: 200px;
    text-align: center; /* Center the button text */
  }
  
  .updateMenu button:hover {
    background-color: #FFB22C;
  }
  </style>
  