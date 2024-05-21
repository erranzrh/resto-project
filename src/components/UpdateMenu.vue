<template>
    <div>
        <AppHeader />
        <div>
            <h1>Hello {{name}}, Welcome to the Update Menu Page</h1>
        </div>
    </div>
</template>

<script>
import AppHeader from './AppHeader.vue'

export default {
    name: 'UpdateMenu',
    components: {
        AppHeader
    },
    mounted() {
        let user = localStorage.getItem('user-info');
        if (!user) {
            this.$router.push({ name: 'SignUp' });
        }
    }
}
</script>
