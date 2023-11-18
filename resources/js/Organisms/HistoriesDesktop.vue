<template>
        <div class="c-button">
            <NewHistory @new_histories="(newHistories) => histories = newHistories"/>
        </div>

        <div class="py-12">
            <div v-if="histories.length > 0" class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card v-for="history in storeHistories" :key="history.id" :history="history" />
            </div>
            <div v-else class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">Mestre, crie seu primeiro mundo!</div>
            </div>
        </div>
</template>

<script>
import { orderBy } from 'lodash';
import Card from '@/Molecules/Card.vue';
import AddButton from '@/Atoms/AddButton.vue';
import NewHistory from '@/Molecules/NewHistory.vue';

export default {
    name: 'HistoriesDesktop',

    components: {
        Card,
        AddButton,
        NewHistory
    },

    data() {
        return {
            addTooltip: 'Criar nova história',
            histories: [],
        }
    },

    created() {
        axios.get(route('histories.desktop.get'))
        .then((response) => {
            this.histories = response.data
        })
    },

    computed: {
        storeHistories: function() {
            return orderBy(this.histories, ['updated_at'], ['desc'])
        }
    }
}
</script>

<style scoped>
.c-button {
    display: flex;
    justify-content: center;
    align-self: center;
    padding: 0.5rem;
}

.c-cards {
    display: flex;
    gap: 1rem;
    justify-content: space-around;
    flex-wrap: wrap;
}
</style>
