<template>
    <div :class="{'pannelReduced' : isPannelReduce}" class="pannelLeft">
        <span class="welcomeDashboard">Bienvenu {{ name }}</span>
        
        <Separator :class="'welcomeDashboard'"></Separator>
        
        <MenuLink label="Réduire le menu" icon="/storage/JADBudget/back.png" @click="reduceMenu"></MenuLink>
        <Separator></Separator>
        
        <MenuLink label="Tableau de bord" icon="/storage/JADBudget/dashboard.png" @click="displayDashboard" @menu-click="$emit('dashboard-click')"></MenuLink>
        <MenuLink label="Profil" icon="/storage/JADBudget/user.png" @click="displayProfile" @menu-click="$emit('profile-click')"></MenuLink>
        
        <Separator></Separator>

        <MenuLink label="Déconnexion" icon="/storage/JADBudget/logout.png" @click="logoutUser"></MenuLink>
    </div>
</template>
<style scoped>
    .separator {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>
<script>
import Separator from './Separator.vue';
import MenuLink from './MenuLink.vue';
import { fetch_result, makeToast } from '../../utils.ts';

export default{
    components: {
        Separator, MenuLink
    },
    props: {

    },
    data(){
        return {
            name : 'Invité',
            isActive: true,
            isPannelReduce: false
        }
    },
    mounted(){
        this.fetchInformations();
    },
    emits: ['dashboard-click', 'profile-click'],
    methods: {
        async fetchInformations(){
            try {
                const result = await fetch_result('/JADBudgetV2/getUserInfos', {
                    _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                });

                this.name = result.userName;

            } catch(error){
                console.log(error);
                makeToast('error.png', 'Une erreur est survenue. Veuillez réessayer');
            }
        },

        displayDashboard(){
            console.log('PannelLeft.vue > displayDashboard()');
        },

        displayProfile(){
            console.log('PannelLeft.vue > displayProfile()');
        },

        logoutUser(){
            window.location.href = "/JADBudgetV2/logout";
        },

        reduceMenu(){
            console.log('PannelLeft.vue > reduceMenu()');
            this.isPannelReduce = !this.isPannelReduce;
        }
    }
}
</script>