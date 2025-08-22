<template>
    <div class="box">
        <h1>{{ title }}</h1>

        <InputField :class="{'loading-state': loading}" name="login" type="text" placeholder="Identifiant" v-model="credentials.login"></InputField>
        <InputField :class="{'loading-state': loading}" name="email" type="email" placeholder="E-mail" v-model="credentials.email"></InputField>
        <InputField :class="{'loading-state': loading}" name="password" type="password" placeholder="Mot de passe" :toggle-type="true" v-model="credentials.password"></InputField>

        <div class="link">
            <a href="#" style="margin-right: 1rem;">Politique de confidentialité</a>
            <span>•</span>
            <a href="#">Mentions légales</a>
            <span>•</span>
            <a href="#" @click.prevent="$emit('toggle-signin')">Connectez-vous</a>
        </div>

        <Button class="w-full" :class="{'loading-state': loading}" label="S'inscrire" :disabled="loading" @click="signin"></Button>

    </div>
</template>

<style>
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
import { fetch_result, makeToast } from '../../utils.ts';

export default {
    components: {
        InputField,
        Button
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
                email: '',
                password: ''
            }
        }
    },
    methods: {
        async signin() {
            this.loading = true;
            
            const data = {
                _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                name: this.credentials.login,
                email: this.credentials.email,
                password: this.credentials.password
            };

            const url = '/JADBudgetV2/signinV2';

            try {
                await fetch_result(url, data);
                makeToast("success.png", "Inscription réussie !");
                
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