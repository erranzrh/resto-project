<template>
  <div class="cart-page">
    <AppHeader class="sidebar" />
    <div class="cart-container">
      <h1 class="title">Your Cart</h1>
      <div v-if="cartItems.length > 0" class="cart-content">
        <div class="cart-items">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Order List</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in cartItems" :key="index">
                <td class="product-info">
                  <div>
                    <strong>{{ item.name }}</strong>
                    <p>{{ item.description }}</p>
                  </div>
                </td>
                <td>RM {{ item.price }}</td>
                <td>
                  <input type="number" v-model="item.quantity" min="1" class="quantity-input" />
                </td>
                <td>RM {{ (item.price * item.quantity).toFixed(2) }}</td>
                <td>
                  <button @click="removeFromCart(index)" class="remove-button">x</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="order-summary">
          <h2>Order Summary</h2>
          <p>Subtotal: RM {{ subtotal.toFixed(2) }}</p>
          <p>Shipping: Free</p>
          <div class="total">
            <p>Total: RM {{ subtotal.toFixed(2) }}</p>
          </div>
          <button @click="confirmOrder" class="confirm-button">Checkout</button>
        </div>
      </div>
      <div v-else class="empty-cart">
        <p>Your cart is empty.</p>
      </div>
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
  computed: {
    subtotal() {
      return this.cartItems.reduce((total, item) => {
        return total + item.price * item.quantity;
      }, 0);
    }
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
.cart-page {
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

.cart-container {
  margin-left: 250px;
  flex-grow: 1;
  padding: 40px;
  background-color: #f5f5f5;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.title {
  font-size: 2em;
  margin-bottom: 20px;
}

.cart-content {
  display: flex;
  width: 100%;
  max-width: 1200px;
}

.cart-items {
  flex: 2;
  margin-right: 20px;
}

.cart-table {
  width: 100%;
  border-collapse: collapse;
}

.cart-table th,
.cart-table td {
  padding: 10px;
  border-bottom: 1px solid #ccc;
  text-align: left;
}

.product-info {
  display: flex;
  align-items: center;
}

.product-image {
  width: 50px;
  height: 50px;
  margin-right: 10px;
}

.quantity-input {
  width: 50px;
  text-align: center;
}

.remove-button {
  background-color: #dc3545;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.remove-button:hover {
  background-color: #c82333;
}

.order-summary {
  flex: 1;
  padding: 20px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.order-summary h2 {
  margin-top: 0;
  font-size: 1.5em;
}

.order-summary p {
  margin: 10px 0;
}

.total {
  font-weight: bold;
  margin-top: 20px;
}

.confirm-button {
  background-color: #28a745;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 20px;
  width: 100%;
  transition: background-color 0.3s;
}

.confirm-button:hover {
  background-color: #218838;
}

.empty-cart {
  text-align: center;
  margin-top: 20px;
}
</style>
