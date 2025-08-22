<template>
    <div class="menuLink" @click="$emit('menu-click')">
        <img class="img-sm" :src="icon" alt="">
        <p>{{ label }}</p>
    </div>
</template>

<script>
export default{
    components: {

    },
    props: {
        label: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            default: '/storage/undefined.png'
        }
    },
    data(){
        return {}
    },
    emits: ['menu-click'],
    mounted(){
        
    },
    methods: {

    }
}
</script>