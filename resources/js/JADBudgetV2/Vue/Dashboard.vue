<template>
    <PannelLeft @dashboard-click="dashboardClicked" @profile-click="profileClicked"></PannelLeft>
    <PannelRight></PannelRight>
</template>

<script>
import PannelLeft from './PannelLeft.vue';
import PannelRight from './PannelRight.vue';

export default{
    components: {
        PannelLeft, PannelRight
    },
    props: {
    },
    data(){
        return {
        }
    },
    mounted() {
    },
    methods: {
        dashboardClicked(){
            console.log('Dashboard.vue > dashboardClicked');
        },
        profileClicked(){
            console.log('Dashboard.vue > profilClicked');
        }
    }
}
</script>