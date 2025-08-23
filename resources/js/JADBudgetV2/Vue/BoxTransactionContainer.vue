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
import { fetch_result, makeToast } from '../../utils.ts';
import BoxTransaction from './BoxTransaction.vue';
export default {
    components: {
        BoxTransaction
    },

    props: {

    },
    data(){
        return {
            invoiceList: [],
            expenseList: [],
            incomeList: [],
        }
    },
    async mounted(){
        this.invoiceList = this.fetch_transaction("INVOICE");
        this.expenseList = this.fetch_transaction("EXPENSE");
        this.incomeList = this.fetch_transaction("INCOME");
    },
    methods: {
        async fetch_transaction(type){
            const data = {
                _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                type: type,
            };

            const url = '/JADBudgetV2/getTransactionsByType';

            try {
                const result = await fetch_result(url, data);
                switch(type){
                    case 'INVOICE':
                        this.invoiceList = result.transactionList;
                        break;
                    case 'EXPENSE':
                        this.expenseList = result.transactionList;
                        break;
                    case 'INCOME':
                        this.incomeList = result.transactionList;
                        break;
                        
                }
            } catch (error) {
                try {
                    const errorResponse = JSON.parse(error.message);
                    
                    if (errorResponse.errors) {
                        const firstError = Object.values(errorResponse.errors)[0][0];
                        makeToast("error.png", firstError);
                    } else {
                        makeToast("error.png", "Une erreur est survenue. Veuillez réessayer.");
                    }

                } catch (parseError) {
                    console.log(parseError);
                    makeToast("error.png", "Une erreur est survenue. Veuillez réessayer.");
                }
                
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>