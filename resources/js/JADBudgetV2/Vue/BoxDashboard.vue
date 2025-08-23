<template>
    <Box label="Tableau de bord"></Box>
    <BoxTransactionContainer></BoxTransactionContainer>
</template>

<script>
import Box from './Box.vue';
import BoxTransactionContainer from './BoxTransactionContainer.vue';

export default {
    components: {
        Box, BoxTransactionContainer
    },
    props: {

    }
}
</script>