<template>
    <div class="signup-container">
        <img src="../assets/DineDynasty.png" alt="Dine Dynasty Logo"/>
        <h1>Sign Up</h1>
    </div>
    <div class="register">
        <input type="text" v-model="name" placeholder="Enter Name"/>
        <input type="text" v-model="email" placeholder="Enter Email"/>
        <input type="password" v-model="password" placeholder="Enter Password"/>
        <button v-on:click="signUp">Register</button>
        <p>
            <router-link to="/login">Login</router-link>
        </p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'SignUp',
    data() {
        return {
            name: '',
            email: '',
            password: ''
        };
    },
    methods: {
        async signUp() {
            try {
                let result = await axios.post("http://localhost:3000/user", {
                    name: this.name,
                    email: this.email,
                    password: this.password
                });

                console.warn(result);
                if (result.status === 201) {
                    localStorage.setItem("user-info", JSON.stringify(result.data));
                    this.$router.push({ name: 'Home' });
                }
            } catch (error) {
                console.error("There was an error during sign-up:", error);
                alert("Sign-up failed. Please try again.");
            }
        }
    },
    mounted() 
    {
        let user = localStorage.getItem('user-info');
        if (user) {
            this.$router.push({ name: 'Home' });
        }
    }
};
</script>

<style>

</style>
