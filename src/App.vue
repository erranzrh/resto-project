<template>
  <!-- <img alt="Vue logo" src="./assets/logo.png"> -->
  <router-view />
</template>

<script>



export default {
  name: 'App',
  
  
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.signup-container {
  text-align: center;
  margin-top: 20px;
}

.signup-container h1 {
  margin-top: 5px; /* Adjust this value to increase or decrease the gap */
  margin-bottom: 0;
  font-size: 40px; /* Adjust the font size as needed */
  font-weight: bold;
}

.signup-container img {
  width: 500px; /* Adjust the size as needed */
}

.register {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}

.register input {
  width: 300px;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

.register button {
  width: 320px;
  padding: 10px;
  margin-top: 10px;
  border: none;
  border-radius: 5px;
  background-color: #6F5A06;
  color: white;
  font-size: 18px;
  cursor: pointer;
}

.register button:hover {
  background-color: #FAD12B;
}


</style>
