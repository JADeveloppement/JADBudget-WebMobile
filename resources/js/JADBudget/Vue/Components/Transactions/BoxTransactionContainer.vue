<template>
    <div class="transactionsContainer">
        <BoxTransaction
            v-for="(list, type) in transactionData"
            :key="type"
            :title="titles[type]"
            :transaction-type="type"
            :items="list"
            :dataLoading="loading"
            @delete-item="deleteItem(type, $event)"
            @add-transaction="addTransaction(type, $event)"
        ></BoxTransaction>
    </div>

    <Popup
        v-if="transactionToAdd !== undefined"
        :action="'add'"
        :type="transactionToAdd"
        @save-transaction="saveTransaction($event)"
        @close-popup="transactionToAdd = undefined"
        ref="popup"
    ></Popup>
</template>

<script>
import { fetch_result, makeToast } from '../../../../utils.ts';
import BoxTransaction from './BoxTransaction.vue';
import Popup from '../Forms/Popup.vue';

export default {
    components: {
        BoxTransaction,
        Popup
    },
    data() {
        return {
            loading: true,
            transactionToAdd: undefined,
            transactionData: {
                income: [],
                invoice: [],
                expense: [],
                modelincome: [],
                modelinvoice: []
            },
            titles: {
                income: "Revenus",
                invoice: "Prélèvements",
                expense: "Dépenses",
                modelincome: "Modèle Revenus",
                modelinvoice: "Modèle Prélèvements"
            }
        };
    },
    async mounted() {
        await this.fetchData();
    },
    methods: {
        async fetchData() {
            this.loading = true;
            try {
                const [income, invoice, expense, modelincome, modelinvoice] = await Promise.all([
                    this.fetchTransaction("INCOME"),
                    this.fetchTransaction("INVOICE"),
                    this.fetchTransaction("EXPENSE"),
                    this.fetchTransaction("MODELINCOME"),
                    this.fetchTransaction("MODELINVOICE")
                ]);
                this.transactionData.income = income;
                this.transactionData.invoice = invoice;
                this.transactionData.expense = expense;
                this.transactionData.modelincome = modelincome;
                this.transactionData.modelinvoice = modelinvoice;
            } catch (error) {
                console.error("Failed to fetch all transactions:", error);
            } finally {
                this.loading = false;
            }
        },
        async fetchTransaction(type) {
            const data = {
                _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                type: type
            };
            const url = '/JADBudget/getTransactionsByType';

            try {
                const result = await fetch_result(url, data);
                return result.transactionList.map(item => ({ id: item[0], label: item[1], amount: item[2] }));
            } catch (error) {
                try {
                    const errorResponse = JSON.parse(error.message);
                    const firstError = Object.values(errorResponse.errors)[0][0];
                    makeToast("error.png", firstError);
                } catch (parseError) {
                    console.log(parseError);
                    makeToast("error.png", "Une erreur est survenue lors de la récupération des transactions.");
                }
                return [];
            }
        },
        addTransaction(transactionType) {
            this.transactionToAdd = transactionType;
        },
        async saveTransaction(transactionSaved) {
            const [type, transaction] = transactionSaved;
            try {
                const data = {
                    _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                    label: transaction.label,
                    amount: transaction.amount,
                    type: type
                };
                const url = '/JADBudget/addTransaction';
                const result = await fetch_result(url, data);

                makeToast('success.png', 'La transaction a été ajoutée avec succès.', 2000);
                
                const newItem = { id: result.id, label: result.label, amount: result.amount };
                if (this.transactionData[type]) {
                    this.transactionData[type].push(newItem);
                } else {
                    console.error(`BoxTransactionContainer.vue > Error: transaction type ${type} not recognized.`);
                }

                this.$refs.popup.clearForm();
            } catch (error) {
                console.error('BoxTransactionContainer.vue > Error:', error);
                makeToast('warning.png', 'Une erreur est survenue, veuillez réessayer.');
            }
        },
        deleteItem(transactionType, idToDelete) {
            this.transactionData[transactionType] = this.transactionData[transactionType].filter(item => item.id !== idToDelete);
        }
    }
}
</script>