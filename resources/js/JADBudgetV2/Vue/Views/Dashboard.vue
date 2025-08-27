<template>
    <PannelLeft @dashboard-click="dashboardClicked" @profile-click="profileClicked"></PannelLeft>
    <PannelRight :dashboardActive="dashboardSelected"></PannelRight>
</template>

<script>
import PannelLeft from '../Layouts/PannelLeft.vue';
import PannelRight from '../Layouts/PannelRight.vue';

export default{
    components: {
        PannelLeft, PannelRight
    },
    props: {
    },
    data(){
        return {
            dashboardSelected: true
        }
    },
    mounted() {
    },
    methods: {
        dashboardClicked(){
            console.log('Dashboard.vue > dashboardClicked');
            this.dashboardSelected = true;
        },
        profileClicked(){
            console.log('Dashboard.vue > profilClicked');
            this.dashboardSelected = false;
        }
    }
}
</script>