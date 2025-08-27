<template>
    <div class="pannelRight">
        <BoxDashboard v-if="dashboardActive"></BoxDashboard>
        <BoxProfil v-if="!dashboardActive"></BoxProfil>
    </div>
</template>
<style scoped>
    h1 {
        color: white;
    }
</style>
<script>
import BoxDashboard from '../Components/UI/BoxDashboard.vue';
import BoxProfil from './../Components/UI/BoxProfil.vue';

export default{
    components: {
        BoxDashboard, BoxProfil
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