<template>
    <div class="inputContainer">
        <input :name="name" :type="fieldType" :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        <img class="img-sm" src="/storage/JADBudget/oeil.png" v-if="toggleType" @click="toggleFieldType">
    </div>
</template>

<style scoped>
    .inputContainer {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    img{
        position: absolute;
        right: 0.5rem;
        cursor: pointer;
        opacity: 0.5;
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
            type: Boolean
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