<template>
    <div class="dashboardContainer">
        <Box label="Tableau de bord" icon="/storage/JADBudget/dashboard.png" classes="box boxTitle"></Box>
        <BoxTransactionContainer></BoxTransactionContainer>
    </div>
</template>

<script>
import Box from './Box.vue';
import BoxTransactionContainer from './../Transactions/BoxTransactionContainer.vue';

export default {
    components: {
        Box, BoxTransactionContainer
    },
    props: {

    }
}
</script>