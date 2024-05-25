<template>
    <div>
        <AppHeader />
        <div>
            <h1>Hello {{name}}, Welcome to the Update Menu Page</h1>
            <form class="addMenu">
                <input type="text" name="name" placeholder="Enter Name" v-model="menu.name"/>
                <input type="text" name="price" placeholder="Enter Price" v-model="menu.price"/>
                <input type="text" name="description" placeholder="Enter Description" v-model="menu.description"/>
                <button type="button" v-on:click="updateMenu">Update Menu</button>
            </form>
        </div>
    </div>
</template>

<script>
import AppHeader from './AppHeader.vue'
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
        async updateMenu(){
            // console.warn(this.menu)
            try {
                const result = await axios.put("http://localhost:3000/menu/"+this.$route.params.id, {
                    name: this.menu.name,
                    price: this.menu.price,
                    description: this.menu.description,
                });
                if (result.status === 200) {
                    this.$router.push({ name: 'Home' });
                }
                console.warn("result", result);
            } catch (error) {
                console.error("Error adding menu:", error);
            }
        }
    },
    async mounted() {
        let user = localStorage.getItem('user-info');
        if (!user) {
            this.$router.push({ name: 'SignUp' });
        }

        const result = await axios.get('http://localhost:3000/menu/'+this.$route.params.id)
        // console.warn(this.$route.params.id)
        // console.warn(result.data)
        this.menu = result.data
    }
}
</script>
