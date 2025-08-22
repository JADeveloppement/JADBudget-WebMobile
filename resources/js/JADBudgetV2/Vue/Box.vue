<template>
    <div class="box">
        {{ label }}
    </div>
</template>

<script>
export default{
    props: {
        label: {
            type: String,
            default: 'Undefined'
        }
    }
}
</script>