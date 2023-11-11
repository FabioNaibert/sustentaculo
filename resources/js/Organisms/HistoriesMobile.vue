<template>
    <div class="py-12">
        <div v-if="histories.length > 0" class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
            <Card v-for="history in histories" :key="history.id" :history="history" />
        </div>
        <div v-else class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">Ainda não há convites para você.</div>
        </div>
    </div>
</template>

<script>
import Card from '@/Molecules/Card.vue';

export default {
    name: 'HistoriesMobile',

    components: {
        Card,
    },

    data() {
        return {
            histories: [],
        }
    },

    created() {
        axios.get(route('histories.mobile.get'))
        .then((response) => {
            this.histories = response.data
        })
    },
}
</script>

<style scoped>
.c-cards {
    display: flex;
    gap: 1rem;
    justify-content: space-around;
    flex-wrap: wrap;
}
</style>
