<template>
    <div class="box">
        <h1>{{ title }}</h1>

        <InputField :class="{'loading-state': loading}" name="login" type="text" placeholder="Identifiant" v-model="credentials.login"></InputField>
        <InputField :class="{'loading-state': loading}" name="password" type="password" placeholder="Mot de passe" :toggle-type="true" v-model="credentials.password"></InputField>

        <div class="link">
            <a href="#" style="margin-right: 1rem;">Politique de confidentialité</a>
            <span>•</span>
            <a href="#">Mentions légales</a>
            <span>•</span>
            <a href="#" @click.prevent="$emit('toggle-signin')">Inscrivez-vous</a>
        </div>
        
        <Button class="w-full" :class="{'loading-state': loading}" label="Se connecter" @click="login"></Button>

    </div>
</template>

<style scoped>
    .box {
        width: 30%;
    }

    h1 {
        margin-bottom: 2rem;
    }

    .link {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;

    }

    .link span {
        margin-left: 1rem;
        margin-right: 1rem;
    }

    .link  a {
        font-size: 0.7rem;
        text-align: center;
    }

    .loading-state {
        opacity: 0.5;
        cursor: not-allowed;
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
    emits: ['toggle-signin'],
    data() {
        return {
            loading: false,
            credentials: {
                login: '',
                password: ''
            }
        }
    },
    methods: {
        async login() {
            this.loading = true;
            try {
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
            } catch (error) {
                console.error("Fetch failed:", error);
                makeToast("error.png", "Une erreur est survenue. Veuillez réessayer.");
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>