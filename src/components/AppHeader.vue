<template>
    <div class="nav">
        <router-link to="/">Home</router-link>
        <router-link to="/add-menu">Add Menu</router-link>
        <a v-onclick="logout" href="#">Logout</a>
    </div>
</template>
<script>
export default {
    name: 'AppHeader'
}
</script>
<style>
.nav{
    background-color: #333;
    overflow: hidden;
}
.nav a{
    float: left;
    color: #f2f2f2;
    padding: 14px 14px;
    text-align: center;
    font-size: 17px;
    text-decoration: none;
    margin-right: 5px;
}
.nav a:hover{
    background-color: #ddd;
    color:#333;
}
</style>
