<template>
    <div class="addTransaction" @click="addTransactionClicked">
        <img class="img-xs" src="/storage/JADBudget/plus.png" alt="">
        <span>Ajouter</span>
    </div>
</template>

<style scoped>
</style>

<script>
export default {
    props: {
        transactionType: {
            type: String,
            required: true,
            default: 'undefined'
        }
    },
    data(){
        return{};
    },
    mounted(){

    },
    emits: ['addTransaction'],
    methods: {
        addTransactionClicked(){
            this.$emit("addTransaction", this.transactionType);
        }
    }
}
</script>