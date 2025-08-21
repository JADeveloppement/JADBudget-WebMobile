<template>
    <BoxLogin title="Se connecter" v-if="!toggleBoxes" @toggle-signin="toggleBox"></BoxLogin>
    <BoxSignin title="S'inscrire" v-if="toggleBoxes" @toggle-signin="toggleBox"></BoxSignin>
</template>

<script>
import BoxLogin from './BoxLogin.vue';
import BoxSignin from './BoxSignin.vue';

export default {
    components: {
        BoxLogin, BoxSignin
    },
    data(){
        return {
            toggleBoxes: false
        };
    },
    mounted(){

    },
    methods: {
        toggleBox(){
            this.toggleBoxes = !this.toggleBoxes;
            console.log(this.toggleBoxes);
        }
    }
}
</script>