<template>
    <button
        :class="classes"
    >
        <slot />
    </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'btn-gradient inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
        : 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
);
</script>

<style scoped>
.btn-gradient {
    background: rgb(31,41,55);
    background: linear-gradient(86deg, rgba(31,41,55,1) 22%, rgba(255,255,255,1) 64%, rgba(255,255,255,1) 100%);
}
</style>

