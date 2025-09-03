<template>
    <div class="popupContainer">
        <div class="popup">
            <div class="title">
                <h1>Ajouter une transaction</h1>
            </div>
            <div class="content">
                <InputField :style="'margin-top: 2rem;'" :name="'labelTransaction'" :type="'text'" :placeholder="'Label de la transaction'" v-model="this.transaction.label" :class="{'warningField' : submitted & !this.transaction.label.length}"></InputField>
                <InputField :name="'labelTransaction'" :type="'number'" :placeholder="'Montant de la transaction'" v-model="this.transaction.amount" :class="{'warningField' : submitted & !this.transaction.amount.length}"></InputField>
                <Button :label="'Ajouter'" :style="'width: 100%;'" @click="addTransaction"></Button>
                <Button :label="'Annuler'" :style="'width: 100%;'" :classes="'cancelButton'" @click="cancelPopup"></Button>
            </div>
        </div>
    </div>
</template>

<script>
import Button from '../Buttons/Button.vue';
import InputField from './InputField.vue';

export default{
    components: {
        Button, InputField
    },
    props: {
        action: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        }
    },
    data(){
        return {
            transaction: {
                label: '',
                amount: ''
            },
            submitted: false
        }
    },
    mounted(){

    },
    emits: ['saveTransaction', 'closePopup'],
    methods: {
        addTransaction(){
            this.submitted = true;
            if (this.transaction.label.length > 0 && this.transaction.amount.length > 0) {
                this.$emit('saveTransaction', [this.type, this.transaction]);
            }
        },
        cancelPopup(){
            this.$emit('closePopup');
        },
        clearForm() {
            this.transaction.label = '';
            this.transaction.amount = '';
            this.submitted = false;
        }
    }
}
</script>