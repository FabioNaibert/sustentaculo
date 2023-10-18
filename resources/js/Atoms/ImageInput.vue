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

<template>
    <label class="custom-file-upload">
        Imagem
        <input
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            :title="tooltip"
        />
    </label>
</template>

<style scoped>
#custom-file-upload {
    background-color: red;
}

input[type="file"] {
    display: none;
}
</style>
