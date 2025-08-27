<template>
    <Box label="Profile utilisateur" icon="/storage/JADBudget/user.png" classes="box boxTitle"></Box>
    <div class="infosContainer">
        <UserGeneralInfos></UserGeneralInfos>
        <UserPasswordInfos></UserPasswordInfos>
    </div>
    <Box v-if="lastlogin.length > 0" classes="box boxLastLogin" :label="'Dernière connexion : ' + lastlogin"></Box>
</template>

<script>
import Box from './Box.vue';
import UserGeneralInfos from '../Users/UserGeneralInfos.vue';
import UserPasswordInfos from '../Users/UserPasswordInfos.vue';
import { fetch_result, makeToast } from '../../../../utils.ts';

export default {
    components: {
        Box, UserGeneralInfos, UserPasswordInfos
    },
    props: {
    },
    data(){
        return {
            lastlogin: ''
        }
    },
    async mounted(){
        this.lastlogin = await this.fetchLastLoginTime();
    },
    methods: {
        async fetchLastLoginTime(){
            const data = {
                _token : document.querySelector('meta[name=_token]').getAttribute('content')
            };

            const url = '/JADBudgetV2/getLastConnectionTime';

            try {
                const result = await fetch_result(url, data);
                console.log(result);
                return result.lastLoginTime;
            } catch(error){
                makeToast('warning.png', 'Une erreur est survenue.');
                console.log(error);
            }
        }
    }
}
</script>