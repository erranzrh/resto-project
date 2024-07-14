<template>
    <div class="menu-container">
      <AppHeader />
      <div class="menu-content">
        <h1>Admin Menu</h1>
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
              <button @click="openEditModal(item)" class="edit-link">Edit</button>
              <button @click="deleteMenu(item.id)" class="delete-button">Delete</button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Edit Modal -->
      <div v-if="showEditModal" class="modal">
        <div class="modal-content">
          <span class="close" @click="closeEditModal">&times;</span>
          <h2>Edit Menu</h2>
          <form class="updateMenu">
            <input type="text" name="name" placeholder="Enter Name" v-model="selectedMenu.name" />
            <input type="text" name="price" placeholder="Enter Price" v-model="selectedMenu.price" />
            <input type="text" name="description" placeholder="Enter Description" v-model="selectedMenu.description" />
            <button type="button" v-on:click="updateMenu">Update Menu</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import AppHeader from './AppHeader.vue';
  
  export default {
    name: 'AdminMenu',
    components: {
      AppHeader
    },
    data() {
      return {
        menuItems: [],
        showEditModal: false,
        selectedMenu: {
          id: '',
          name: '',
          price: '',
          description: ''
        }
      };
    },
    methods: {
      async loadMenu() {
        try {
          const response = await axios.get('http://localhost:8000/api/menus');
          this.menuItems = response.data;
        } catch (error) {
          console.error('Error loading menu:', error);
        }
      },
      openEditModal(item) {
        this.selectedMenu = { ...item };
        this.showEditModal = true;
      },
      closeEditModal() {
        this.showEditModal = false;
        this.selectedMenu = {
          id: '',
          name: '',
          price: '',
          description: ''
        };
      },
      async updateMenu() {
        try {
          const result = await axios.put(`http://localhost:8000/api/menus/${this.selectedMenu.id}`, {
            name: this.selectedMenu.name,
            price: this.selectedMenu.price,
            description: this.selectedMenu.description,
          });
          if (result.status === 200) {
            this.loadMenu();
            this.closeEditModal();
          } else {
            console.error("Update failed with status:", result.status);
          }
        } catch (error) {
          console.error("Error updating menu:", error);
        }
      },
      async deleteMenu(id) {
        try {
          await axios.delete(`http://localhost:8000/api/menus/${id}`);
          this.loadMenu();
        } catch (error) {
          console.error('Error deleting menu:', error);
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
  
  .menu-content {
    flex-grow: 1;
    padding: 20px;
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
    color: #007bff;
    font-size: 1.2em;
    margin: 10px 0;
  }
  
  .card-description {
    margin-bottom: 20px;
  }
  
  .card-actions {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .edit-link {
    color: #007bff;
    text-decoration: none;
    padding: 8px 12px;
    border: 1px solid #007bff;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .edit-link:hover {
    background-color: #007bff;
    color: white;
  }
  
  .delete-button {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .delete-button:hover {
    background-color: #e53935;
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
  
  /* Modal styles */
  .modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
  }
  
  .modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    text-align: center;
  }
  
  .close {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 1.5em;
    cursor: pointer;
  }
  
  .updateMenu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 20px;
  }
  
  .updateMenu input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
  }
  
  .updateMenu button {
    padding: 10px;
    border: none;
    background-color: #FFB22C;
    color: white;
    font-size: 1em;
    cursor: pointer;
    border-radius: 4px;
    text-align: center;
  }
  
  .updateMenu button:hover {
    background-color: #FFA500;
  }
  </style>
  