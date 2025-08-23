<template>
    <div class="transactionsContainer">
        <BoxTransaction title="Revenus" :items='incomeList'></BoxTransaction>
        <BoxTransaction title="Prélèvements" :items='invoiceList'></BoxTransaction>
        <BoxTransaction title="Dépenses" :items='expenseList'></BoxTransaction>
        <BoxTransaction title="Modèle Prélèvements"></BoxTransaction>
    </div>
</template>
<style scoped>
</style>
<script>
import BoxTransaction from './BoxTransaction.vue';
export default {
    components: {
        BoxTransaction
    },

    props: {

    },
    data(){
        return {
            invoiceList: []
        }
    }
}
</script>