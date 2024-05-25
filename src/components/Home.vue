<template>
    <div>
        <AppHeader />
        <div>
            <h1>Hello {{name}}, Welcome to the Home Page</h1>
            <div class = table-container>
                <table border="1px">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <tr v-for="item in menu" :key="item.id">
                <td>{{item.name }}</td>
                <td>RM {{item.price }}</td>
                <td>{{item.description }}</td>
                <td><router-link :to="'/update-menu/'+item.id">Update</router-link>
                <button v-on:click= "deleteRestaurant(item.id)">Delete</button></td>
            </tr>
            </table>
            </div>
        </div>
    </div>
</template>

<script>
import AppHeader from './AppHeader.vue'
import axios from 'axios';
export default {
    name: 'HomePage',
    data(){
        return{
            name:'',
            menu:[],
        }
    },
    components: {
        AppHeader
    },

    methods: {
        async deleteRestaurant(id){
            let result =await axios.delete("http://localhost:3000/menu/"+ id);
            console.warn(result)
            if(result.status==200)
            {
                this.loadData()
            }
        },
        async loadData()
        {
        let user = localStorage.getItem('user-info');
        this.name = JSON.parse(user).name
        if (!user) {
            this.$router.push({ name: 'SignUp' });
        }
        let result = await axios.get("http://localhost:3000/menu");
        console.warn(result)
        this.menu = result.data;
        }
        
    },

    async mounted() 
    {
        this.loadData();

    }
}
</script>
<style>
.table-container {
    display: flex;
    justify-content: center;
}

table {
    border-collapse: collapse;
}

td, th {
    width: 300px;
    height: 40px;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

table, th, td {
    border: 1px solid black;
}
</style>
