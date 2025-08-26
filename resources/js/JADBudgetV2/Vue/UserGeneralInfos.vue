<template>
    <div class="box usergeneralinfos">
        <h1>Informations générales</h1>

        <InputField name="login" type="text" placeholder="Identifiant" v-model="this.credentials.username" :class="{'warningField' : submitted & !this.credentials.username.length}" :read-only="true"></InputField>
        <InputField name="email" type="email" placeholder="E-mail" v-model="this.credentials.email" :class="{'warningField' : submitted & !this.credentials.email.length}"></InputField>
        <InputField name="passwordInfos" type="password" :toggle-type="true" placeholder="Confirmer votre mot de passe" v-model="this.credentials.password" :class="{'warningField' : submitted & !this.credentials.password.length}"></InputField>

        <Button label="Sauvegarder" @click="saveInformations"></Button>
    </div>
</template>

<style scoped>
</style>
<script>
import Button from './Button.vue';
import InputField from './InputField.vue';
import { fetch_result, makeToast } from '../../utils.ts';

export default{
    components: {
        InputField, Button
    },
    props: {

    },
    data(){
        return {
            submitted: false,
            credentials: {
                username: '',
                email: '',
                password: ''
            }
        };
    },
    async mounted(){
        const infos = await this.fetch_userinfos();
        this.credentials.username = infos.name;
        this.credentials.email = infos.email;
    },
    methods: {
        async fetch_userinfos(){
            const url = '/JADBudgetV2/getUserInfos';
            const data = {
                _token: document.querySelector('meta[name=_token]').getAttribute('content')
            };

            try {
                const result = await fetch_result(url, data);
                return {
                    name: result.userName,
                    email: result.userEmail
                }
            } catch(error){
                makeToast('error.png', 'Une erreur est survenue, veuillez réessayer.');
                console.log('UserGeneralInfos.vue > Erreur : ', error);
            }
        },
        async saveInformations(){
            this.submitted = true;
            if (this.credentials.username.length && this.credentials.email.length && this.credentials.password.length){
                const url = "/JADBudgetV2/updateUserInfos";
                const data = {
                    _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                    name: this.credentials.username,
                    email: this.credentials.email,
                    password: this.credentials.password
                }

                try {
                    await fetch_result(url, data);
                    makeToast('success.png', 'Les informations ont été mise à jour.');
                } catch(error){
                    try {
                        const errorMessage = JSON.parse(error.message);
                        if (errorMessage.message) makeToast('warning.png', errorMessage.message);
                        else makeToast('error.png', 'Une erreur est survenue, veuillez réessayer.', 3000);
                        console.log('UserGeneralInfos.vue > Error : ', errorMessage);
                    } catch(error){
                        console.log('UserGeneralInfos.vue > Error : ', error);
                        makeToast('error.png', 'Une erreur est survenue, veuillez réessayer.');
                    }
                }
            }
        }
    }
}
</script>