<template>
    <div class="box">
        <div class="title">
            <div class="addTransaction"></div>
            <h1>{{ title }}</h1>
            <div class="nbOfElements">{{this.items.length}}</div>
        </div>
        <div class="content">
            <ButtonAddTransaction :transaction-type="this.transactionType" @add-transaction="addTransaction"></ButtonAddTransaction>
            <div style="position: relative" v-if="items && items.length > 0">
                <ul>
                    <li class="transactionItem" v-for="(item, index) in items" :key="index" :data-id="item[0]">
                        <div class="label">
                            <span>{{ item[1] }}</span>
                            <div class="amount">
                                {{ item[2] }} €
                            </div>
                        </div>
                        <div class="transactionAction" @click="deleteTransaction(item)">
                            <img class="img-sm" src="/storage/JADBudget/trash.png" alt="">
                        </div>
                    </li>
                </ul>
            </div>
            <div v-else class="item-list">
                <ul>
                    <li>{{ this.dataLoading ? "Chargement..." : "Aucun élément." }}</li>
                </ul>
            </div>
        </div>
        <div v-if="totalAmount != 0" class="totalOfBox">
            Total : {{ totalAmount }} €
        </div>
    </div>
</template>
<script>
import { fetch_result, makeToast } from '../../../../utils.ts';
import ButtonAddTransaction from '../Buttons/ButtonAddTransaction.vue';

export default {
    components: {
        ButtonAddTransaction
    },
    props: {
        title: {
            type: String,
            required: true,
        },
        items: {
            type: Array,
            default: () => []
        },
        dataLoading: {
            type: Boolean,
            default: false
        },
        transactionType: {
            type: String,
            required: true,
            default: 'undefined'
        }
    },
    data(){
        return {
            totalAmount: 0
        };
    },
    mounted(){
    },
    emits: ['delete-item', 'addTransaction'],
    watch: {
        items: {
            handler(newItems){
                this.calculateTotal(newItems);
            },
            setImmediate: true
        }
    },
    methods: {
        async deleteTransaction(transactionToDelete) {
            const data = {
                _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                transaction_id: transactionToDelete[0]
            };

            const url = '/JADBudget/deleteTransaction';

            try {
                await fetch_result(url, data);
                this.$emit('delete-item', transactionToDelete[0]);
                makeToast('success.png', `Transaction ${transactionToDelete[1]} supprimée avec succès.`);
            } catch(error){
                console.log(error);
                makeToast('warning.png', `Une erreur est survenue, veuillez réessayer.`);
            }
        },
        addTransaction(){
            this.$emit('addTransaction', this.transactionType);
        },
        calculateTotal(items) {
            let total = 0;
            if (items && items.length > 0) {
                total = items.reduce((sum, item) => sum + parseFloat(item[2]), 0);
            }
            this.totalAmount = Math.round(total * 100) / 100;
        }
    }
}
</script>