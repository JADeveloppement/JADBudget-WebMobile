<template>
    <div class="box">
        <h1>{{ title }}</h1>

        <InputField name="login" type="text" placeholder="Identifiant" v-model="credentials.login"></InputField>
        <InputField name="email" type="email" placeholder="E-mail" v-model="credentials.email"></InputField>
        <InputField name="password" type="password" placeholder="Mot de passe" :toggle-type="true" v-model="credentials.password"></InputField>

        <Button label="S'inscrire" @click="signin"></Button>

    </div>
</template>

<script>
import InputField from './InputField.vue';
import Button from './Button.vue';

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
    data() {
        return {
            credentials: {
                login: '',
                email: '',
                password: ''
            }
        }
    },
    methods: {
        signin() {
            console.log('Attempting signin with:', this.credentials);
        }
    }
}
</script>