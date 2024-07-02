<template>
    <div class="cart-container">
      <AppHeader />
      <h1>Shopping Cart</h1>
      <div v-if="cartItems.length > 0" class="cart-items">
        <ul>
          <li v-for="(item, index) in cartItems" :key="index" class="cart-item">
            <div class="item-details">
              <div>
                <strong>{{ item.name }}</strong> - RM {{ item.price }}
              </div>
              <div class="remarks-section">
                <label>Remarks or Customization:</label>
                <textarea v-model="item.remarks" placeholder="Add remarks or customization"></textarea>
              </div>
              <div class="option-section">
                <label>Choose Option:</label>
                <div class="option-select">
                  <select v-model="item.option">
                    <option value="takeaway">Take Away</option>
                    <option value="dinein">Dine In</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="item-actions">
              <button @click="removeFromCart(index)" class="remove-button">Remove</button>
            </div>
          </li>
        </ul>
        <button @click="confirmOrder" class="confirm-button">Confirm Order</button>
      </div>
      <div v-else class="empty-cart">
        <p>Your cart is empty.</p>
      </div>
    </div>
  </template>
  
  <script>
  import AppHeader from './AppHeader.vue';
  
  export default {
    name: 'CartPage',
    components: {
      AppHeader
    },
    data() {
      return {
        cartItems: []
      };
    },
    methods: {
      confirmOrder() {
        alert('Order confirmed! Please pay at the counter.');
        this.cartItems = [];
        localStorage.removeItem('cart');
        this.$router.push({ name: 'Home' });
      },
      removeFromCart(index) {
        this.cartItems.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(this.cartItems));
        alert('Item removed from cart.');
      }
    },
    mounted() {
      let cart = localStorage.getItem('cart');
      if (cart) {
        this.cartItems = JSON.parse(cart);
      }
    }
  };
  </script>
  
  <style scoped>
  .cart-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .cart-items {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .cart-item {
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .item-details {
    flex: 1;
  }
  
  .remarks-section {
    margin-bottom: 10px;
  }
  
  .remarks-section label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  .remarks-section textarea {
    width: 100%;
    height: 30px;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .option-section {
    margin-bottom: 10px;
  }
  
  .option-section label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  .option-select select {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
  }
  
  .item-actions {
    margin-left: 10px;
  }
  
  .remove-button {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .remove-button:hover {
    background-color: #c82333;
  }
  
  .confirm-button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
  }
  
  .confirm-button:hover {
    background-color: #0056b3;
  }
  
  .empty-cart {
    text-align: center;
    margin-top: 20px;
  }
  </style>
  