<template>
    <div class="pannelRight">
        <Box v-if="dashboardActive" label="Tableau de bord"></Box>
        <Box v-if="!dashboardActive" label="Paramètre du compte"></Box>
    </div>
</template>
<style scoped>
    h1 {
        color: white;
    }
</style>
<script>
import Box from './Box.vue';

export default{
    components: {
        Box
    },
    props: {
        dashboardActive: {
            type: Boolean,
            default: true
        }
    },
    data(){
        return{
        }
    },
    mounted(){

    },
    methods: {

    }
}
</script>