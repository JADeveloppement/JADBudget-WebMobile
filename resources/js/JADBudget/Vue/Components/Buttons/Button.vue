<template>
    <button :class="classes" @click="$emit('click')">
        <img v-if="hasIcon" class="img-sm" :src="icon" alt="">
        <span>{{ label }}</span>
    </button>
</template>

<style scoped>
    button {
        margin-top: 2rem;
    }
</style>

<script>
export default{
    props: {
        classes: {
            type: String
        },
        label: {
            type: String,
            required: true
        },
        icon: {
            type: String
        },
        hasIcon: {
            type: Boolean,
        }
    },
    emits: ['click'],
    data(){
        return {
            
        };
    }
}
</script>