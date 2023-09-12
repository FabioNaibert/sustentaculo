<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container__history">
            <div class="c-esquerda">
                <div class="esquerda__1"><Player /></div>
                <hr>
                <div class="esquerda__2"></div>
            </div>

            <div class="c-meio"></div>

            <div class="c-direita">
                <div class="direita__1"></div>
                <hr>
                <div class="direita__2"></div>
            </div>
        </div>

        <!-- <div class="c-button">
            <NewHistory />
        </div>

        <div class="py-12">
            <div v-if="histories.length > 0" class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card v-for="history in histories" :key="history.id" :history="history" />
            </div>
            <div v-else class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">Mestre, crie seu primeiro mundo!</div>
            </div>
        </div> -->
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Molecules/Card.vue';
import { Head } from '@inertiajs/vue3';
import AddButton from '@/Atoms/AddButton.vue';
import NewHistory from '@/Molecules/NewHistory.vue';
import Player from '@/Molecules/Player.vue';

export default {
    name: 'History',

    props: ['histories'],

    components: {
        AuthenticatedLayout,
        Card,
        Head,
        AddButton,
        NewHistory,
        Player
    },

    data() {
        return {
            addTooltip: 'Criar nova história'
        }
    },
}
</script>

<style scoped>
hr {
    width: 90%;
}

.container__history {
    display: flex;
    width: 100%;
    height: calc(calc(100vh - 4rem) - 1px);
}
.c-esquerda, .c-direita {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 33%;
    height: 100%;
    box-shadow: inset 0 0 1.1rem #a7a7a7;
}

.c-meio {
    display: flex;
    width: 100%;
    /* border: 1px solid blue; */
    height: 100%;
}

/* .c-direita {
    display: flex;
    width: 33%;
    height: 100%;
    box-shadow: inset 0 0 1.1rem #a7a7a7;
} */

.esquerda__1, .esquerda__2, .direita__1, .direita__2 {
    width: 100%;
    height: 50%;
    padding: 0.5rem;
}
</style>
