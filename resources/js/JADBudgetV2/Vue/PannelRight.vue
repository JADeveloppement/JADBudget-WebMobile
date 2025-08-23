<template>
    <div class="pannelRight">
        <BoxDashboard v-if="dashboardActive" label="Tableau de bord"></BoxDashboard>
        <BoxProfil v-if="!dashboardActive" label="Paramètre du compte"></BoxProfil>
    </div>
</template>
<style scoped>
    h1 {
        color: white;
    }
</style>
<script>
import BoxDashboard from './BoxDashboard.vue';
import BoxProfil from './BoxProfil.vue';

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