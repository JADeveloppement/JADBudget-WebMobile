<template>
    <div class="pannelLeft">
        <span>Bienvenu {{ name }}</span>
        <p>Pannel Left</p>
    </div>
</template>

<script>
import { fetch_result, makeToast } from '../../utils.ts';

export default{
    components: {

    },
    props: {

    },
    data(){
        return {
            name : 'Invité'
        }
    },
    mounted(){
        this.fetchInformations();
    },
    methods: {
        async fetchInformations(){
            const result = await fetch_result('/JADBudgetV2/getUserInfos', {
                _token: document.querySelector('meta[name=_token]').getAttribute('content'),
            });

            if (result.status == 200){
                const info = await result.json();
                this.name = info.login;
            }

        }
    }
}
</script>