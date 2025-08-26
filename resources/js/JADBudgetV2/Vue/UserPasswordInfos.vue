<template>
    <div class="box usergeneralinfos">
        <h1>Changer son mot de passe</h1>

        <InputField name="oldPassword" type="password" placeholder="Ancien mot de passe" :toggle-type="true" v-model="this.passwords.oldPassword" :class="{'warningField' : submitted & !this.passwords.oldPassword.length}"></InputField>
        <InputField name="newPassword" type="password" placeholder="Nouveau mot de passe" :toggle-type="true" v-model="this.passwords.newPassword" :class="{'warningField' : submitted & !this.passwords.newPassword.length}"></InputField>
        <InputField name="confirmPassword" type="password" placeholder="Confirmer le nouveau mot de passe" :toggle-type="true" v-model="this.passwords.confirmPassword" :class="{'warningField' : submitted & !this.passwords.confirmPassword.length}"></InputField>

        <Button label="Sauvegarder" @click="saveNewPassword"></Button>
    </div>
</template>

<style scoped>
</style>
<script>
import { fetch_result, makeToast } from '../../utils.ts';
import Button from './Button.vue';
import InputField from './InputField.vue';

export default{
    components: {
        InputField, Button
    },
    props: {

    },
    data(){
        return {
            submitted: false,
            passwords: {
                oldPassword: '',
                newPassword: '',
                confirmPassword: ''
            }
        };
    },
    mounted(){

    },
    methods: {
        async saveNewPassword(){
            this.submitted = true;

            if (this.passwords.oldPassword.length && this.passwords.newPassword.length && this.passwords.confirmPassword){
                if (this.passwords.newPassword !== this.passwords.confirmPassword){
                    makeToast('error.png', 'La confirmation du nouveau mot de passe est mauvaise.');
                    return;
                }

                const data = {
                    _token: document.querySelector('meta[name=_token]').getAttribute('content'),
                    oldPassword: this.passwords.oldPassword,
                    newPassword: this.passwords.newPassword
                };

                const url = '/JADBudgetV2/updatePassword';

                try {
                    await fetch_result(url, data);
                    makeToast('success.png', 'Le mot de passe a été modifié avec succès', 3000);
                } catch(error){
                    try {
                        const errorMessage = JSON.parse(error.message);
                        if (errorMessage.message) makeToast('warning.png', errorMessage.message);
                        else makeToast('error.png', 'Une erreur est survenue, veuillez réessayer.', 3000);
                        console.log('UserPasswordInfos.vue > Error : ', errorMessage);
                    } catch(error){
                        makeToast('error.png', 'Une erreur est survenue, veuillez réessayer.');
                        console.log('UserPasswordInfos.vue > Error : ', error);
                    }
                }
            }
        }
    }
}
</script>