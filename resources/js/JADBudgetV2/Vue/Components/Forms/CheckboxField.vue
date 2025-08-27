<template>
    <div class="checkboxContainer">
        <input type="checkbox" id="checkboxField" :checked="modelValue" @change="$emit('update:modelValue', $event.target.checked)"/>
        <span>{{ label }}</span>
    </div>
</template>

<script>
export default{
    props: {
        modelValue: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            required: true
        }
    },
    emits: ['update:modelValue'],
}
</script>