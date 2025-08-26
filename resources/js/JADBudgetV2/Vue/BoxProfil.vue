<template>
    <Box label="Profile utilisateur" icon="/storage/JADBudget/user.png" classes="box boxTitle"></Box>
    <div class="infosContainer">
        <UserGeneralInfos></UserGeneralInfos>
        <UserPasswordInfos></UserPasswordInfos>
    </div>
</template>

<script>
import Box from './Box.vue';
import UserGeneralInfos from './UserGeneralInfos.vue';
import UserPasswordInfos from './UserPasswordInfos.vue';

export default {
    components: {
        Box, UserGeneralInfos, UserPasswordInfos
    },
    props: {

    }
}
</script>