<template>
    <div>
        <AppHeader />
        <div>
            <h1>Hello {{ name }}, Welcome to the Add Menu Page</h1>
            <form class="addMenu">
                <input type="text" name="name" placeholder="Enter Name" v-model="menu.name"/>
                <input type="text" name="price" placeholder="Enter Price" v-model="menu.price"/>
                <input type="text" name="description" placeholder="Enter Description" v-model="menu.description"/>
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
                const result = await axios.post("http://localhost:3000/menu", {
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