<template>
    <Box label="Profile utilisateur" icon="/storage/JADBudget/user.png" classes="box boxTitle"></Box>
    <div class="infosContainer">
        <UserGeneralInfos></UserGeneralInfos>
        <UserPasswordInfos></UserPasswordInfos>
    </div>
</template>

<script>
import Box from './Box.vue';
import UserGeneralInfos from '../Users/UserGeneralInfos.vue';
import UserPasswordInfos from '../Users/UserPasswordInfos.vue';

export default {
    components: {
        Box, UserGeneralInfos, UserPasswordInfos
    },
    props: {

    }
}
</script>