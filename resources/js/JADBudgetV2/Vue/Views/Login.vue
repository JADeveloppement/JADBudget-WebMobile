<template>
    <BoxLogin title="Se connecter" v-if="!toggleBoxes" @toggle-signin="toggleBox" @display-legal-mentions="displayLegalMentions" @display-confidentiality-policies="displayPolicies"></BoxLogin>
    <BoxSignin title="S'inscrire" v-if="toggleBoxes" @toggle-signin="toggleBox" @display-legal-mentions="displayLegalMentions" @display-confidentiality-policies="displayPolicies"></BoxSignin>
    <LegalMentions></LegalMentions>
    <Confidentiality></Confidentiality>
</template>

<script>
import BoxLogin from '../Components/UI/BoxLogin.vue';
import BoxSignin from '../Components/UI/BoxSignin.vue';
import LegalMentions from '../../../components/LegalMentions.vue';
import Confidentiality from '../../../components/Confidentiality.vue';

export default {
    components: {
        BoxLogin, BoxSignin, LegalMentions, Confidentiality
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
        },
        displayLegalMentions(){
            const legalMentionsContainer = document.querySelector('.legalMentions');
            if (legalMentionsContainer){
                legalMentionsContainer.style.top = 0;
                legalMentionsContainer.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        },
        displayPolicies(){
            const policiesContainer = document.querySelector('.confidentialityPolicies');
            if (policiesContainer){
                policiesContainer.style.top = 0;
                policiesContainer.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }
    }
}
</script>