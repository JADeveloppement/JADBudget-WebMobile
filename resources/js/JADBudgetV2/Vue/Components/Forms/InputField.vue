<template>
    <div class="inputContainer">
        <input :name="name" :type="fieldType" :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :readonly="readOnly">
        <img class="img-sm" src="/storage/JADBudget/oeil.png" v-if="toggleType" @click="toggleFieldType">
    </div>
</template>

<style scoped>
    .warningField > input {
        border-style: solid;
        border-width: 2px;
        border-color: #EF4444 !important;
    }
</style>

<script>
export default {
    props: {
        modelValue: String,
        name: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
        },
        toggleType: {
            type: Boolean,
            default: false
        },
        readOnly: {
            type: Boolean,
            default: false
        }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            fieldType: this.type
        };
    },
    methods: {
        toggleFieldType() {
            this.fieldType = this.fieldType == "password" ? "text" : "password"; 
        }
    }
}
</script>