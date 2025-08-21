<template>
    <div class="box">
        <h1>{{ title }}</h1>

        <InputField name="login" type="text" placeholder="Identifiant" v-model="credentials.login"></InputField>
        <InputField name="password" type="password" placeholder="Mot de passe" :toggle-type="true" v-model="credentials.password"></InputField>

        <Separator></Separator>
        
        <Button class="w-full" label="Se connecter" @click="login"></Button>

    </div>
</template>

<style scoped>
    .box {
        width: 33%;
    }

    h1 {
        margin-bottom: 2rem;
    }
</style>

<script>
import InputField from './InputField.vue';
import Button from './Button.vue';
import Separator from './Separator.vue';
import { fetch_result, makeToast } from '../../utils.ts';

export default {
    components: {
        InputField,
        Button,
        Separator
    },
    props: {
        title: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            credentials: {
                login: '',
                password: ''
            }
        }
    },
    methods: {
        async login() {
            const result = await fetch_result('/JADBudget/login', {
                _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                login: this.credentials.login,
                password: this.credentials.password
            });

            switch(result.status){
                case 200:
                    makeToast("success.png", "Connexion avec succès", 1500, (() => { window.location.href = '/JADBudgetV2/dashboard' }));
                    break;
                default:
                    makeToast("error.png", "Nous n'avons pas pu vous identifier.");
            }
        }
    }
}
</script>