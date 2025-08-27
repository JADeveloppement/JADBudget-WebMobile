<template>
    <div class="transactionsContainer">
        <BoxTransaction title="Revenus" :transaction-type="'income'" :items='incomeList' :dataLoading="loading" @delete-item="deleteItem('income', $event)" @add-transaction="addTransaction('income', $event)"></BoxTransaction>
        <BoxTransaction title="Prélèvements" :transaction-type="'invoice'" :items='invoiceList' :dataLoading="loading" @delete-item="deleteItem('invoice', $event)" @add-transaction="addTransaction('invoice', $event)"></BoxTransaction>
        <BoxTransaction title="Dépenses" :transaction-type="'expense'" :items='expenseList' :dataLoading="loading" @delete-item="deleteItem('expense', $event)" @add-transaction="addTransaction('expense', $event)"></BoxTransaction>
        <BoxTransaction title="Modèle Prélèvements" :transaction-type="'modelinvoice'" :items='modelInvoiceList' :dataLoading="loading" @delete-item="deleteItem('modelinvoice', $event)" @add-transaction="addTransaction('modelinvoice', $event)"></BoxTransaction>
    </div>

    <Popup v-if="this.transactionToAdd !== 'undefined'" :action="'add'" :type="transactionToAdd" @save-transaction="saveTransaction($event)" @close-popup="this.transactionToAdd = 'undefined'" ref="popup"></Popup>
</template>
<script>
import { fetch_result, makeToast } from '../../../../utils.ts';
import BoxTransaction from './BoxTransaction.vue';
import Popup from '../Forms/Popup.vue';

export default {
    components: {
        BoxTransaction, Popup
    },
    data(){
        return {
            loading: true,
            transactionToAdd: 'undefined',
            invoiceList: [],
            expenseList: [],
            incomeList: [],
            modelInvoiceList: []
        }
    },
    async mounted(){
        const [invoiceList, expenseList, incomeList, modelInvoiceList] = await Promise.all([
            this.fetch_transaction("INVOICE"),
            this.fetch_transaction("EXPENSE"),
            this.fetch_transaction("INCOME"),
            this.fetch_transaction("MODELINVOICE")
        ]);

        this.invoiceList = invoiceList;
        this.expenseList = expenseList;
        this.incomeList = incomeList;
        this.modelInvoiceList = modelInvoiceList;
    },
    methods: {
        async fetch_transaction(type){
            this.loading = true;
            const data = {
                _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                type: type,
            };

            const url = '/JADBudgetV2/getTransactionsByType';

            try {
                const result = await fetch_result(url, data);
                return result.transactionList;
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

                return [];
                
            } finally {
                this.loading = false;
            }
        },
        addTransaction(transactionType){
            this.transactionToAdd = transactionType;
        },
        async saveTransaction(transactionSaved){
            try {
                const data = {
                    _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                    label: transactionSaved[1].label,
                    amount: transactionSaved[1].amount,
                    type: transactionSaved[0]
                };

                const url = '/JADBudget/addTransaction';

                const result = await fetch_result(url, data);
                makeToast('success.png', 'La transaction a été ajoutée avec succès.', 2000);

                switch(transactionSaved[0]){
                    case 'invoice':
                        this.invoiceList.push([result.id, result.label, result.amount]);
                        break;
                    case 'income':
                        this.incomeList.push([result.id, result.label, result.amount]);
                        break;
                    case 'expense':
                        this.expenseList.push([result.id, result.label, result.amount]);
                        break;
                    case 'modelinvoice':
                        this.modelInvoiceList.push([result.id, result.label, result.amount]);
                        break;
                    default:
                        makeToast('error.png', 'Une erreur est survenue.');
                        console.log(`BoxTransactionContainer.vue > Error : transaction type ${transactionSaved[0]} not recognized.`);
                }

                this.$refs.popup.clearForm();

            } catch(error){
                console.lof('BoxTransactionContainer.vue > Error : ', error);
                makeToast('warning.png', 'Une erreur est survenue, veuillez réessayer.');

            }
        },
        closePopup(){
            this.transactionToAdd = 'undefined';
        },
        deleteItem(transactionType, idToDelete){
            switch(transactionType){
                case 'invoice':
                    this.invoiceList = this.invoiceList.filter(item => item[0] !== idToDelete);
                    break;
                case 'income':
                    this.incomeList = this.incomeList.filter(item => item[0] !== idToDelete);
                    break;
                case 'expense':
                    this.expenseList = this.expenseList.filter(item => item[0] !== idToDelete);
                    break;
                case 'modelinvoice':
                    this.modelInvoiceList = this.modelInvoiceList.filter(item => item[0] !== idToDelete);
                    break;
                default:
                    // empty
                    break;
            }
        }
    }
}
</script>