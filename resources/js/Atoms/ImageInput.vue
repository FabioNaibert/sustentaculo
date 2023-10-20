<template>
    <div class="c-image">
        <label
            class="custom-file-upload"
            for="input-image"
        >
            IMAGEM:
        </label>
        <input
            id="input-image"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.files[0])"
            ref="input"
            :title="tooltip"
            type="file"
        >
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        required: true,
    },
    tooltip: {
        type: String,
        required: true,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<style scoped>
.c-image {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

input::file-selector-button {
    --tw-text-opacity: 1;
    --tw-bg-opacity: 1;

    color: rgb(255 255 255 / var(--tw-text-opacity));
    letter-spacing: 0.1em;
    font-size: 0.75rem;
    line-height: 1rem;
    background-color: rgb(31 41 55 / var(--tw-bg-opacity));
    border-width: 1px;
    border-color: transparent;
    border-radius: 0.375rem;
    cursor: pointer;
}

input:focus {
    outline: none;
}
</style>
