<template>
    <select v-model="selectedOption" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option disabled :value="null" hidden v-if="placeholder">{{ placeholder }}</option>
        <option v-for="option in options" :key="option.name" :value="option">{{ option.name }}</option>
    </select>
</template>

<script>
export default {
    name: 'SelectWithoutLabel',

    props: [
        'placeholder',
        'options'
    ],

    emits: [
        'selectedOption'
    ],

    data() {
        return {
            selectedOption: null
        }
    },

    created() {
        if (!this.placeholder) {
            this.selectedOption = this.options.find((element) => element);
        }
    },

    watch: {
        selectedOption: function(newSelectedOption) {
            this.$emit('selectedOption', newSelectedOption)
        }
    }
}
</script>

<style scoped>
.default-option {
    color: #818794;
}
</style>
