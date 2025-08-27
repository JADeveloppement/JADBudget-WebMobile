<template>
    <div :class="classes">
        <img v-if="this.icon.length > 0" class="img-sm" :src="icon" alt="">
        <span>{{ label }}</span>
    </div>
</template>
<style>
    .boxLastLogin {
        font-size: 0.8rem;
        font-style: italic;
        margin-top: 1.5rem;
        width: fit-content;
        text-align: left;
    }

    .boxLastLogin > span {
        width: fit-content;
        text-align: left;
    }
    .boxTitle {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }

    .boxTitle > img {
        margin-right: 1rem;
    }

    .boxTitle > span {
        font-weight: bold;
        font-size: larger;
    }
</style>
<script>
export default{
    props: {
        label: {
            type: String,
            default: 'Undefined'
        },
        icon: {
            type: String,
            default: ''
        },
        classes: {
            type: String,
            default: 'box'
        }
    }
}
</script>