<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <div class="c-button">
            <NewHistory />
        </div>

        <div class="py-12">
            <div v-if="histories.length > 0" class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card v-for="history in histories" :key="history.id" :history="history" />
            </div>
            <div v-else class="c-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">Mestre, crie seu primeiro mundo!</div>
            </div>
        </div>

        <button @click="teste">Teste</button>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Molecules/Card.vue';
import { Head } from '@inertiajs/vue3';
import AddButton from '@/Atoms/AddButton.vue';
import NewHistory from '@/Molecules/NewHistory.vue';

export default {
    name: 'Dashboard',

    props: ['histories'],

    components: {
        AuthenticatedLayout,
        Card,
        Head,
        AddButton,
        NewHistory
    },

    data() {
        return {
            addTooltip: 'Criar nova história'
        }
    },

    created() {
        window.Pusher.channel('update-game')
        .listen('UpdateGameEvent', (e) => {
            console.log('socketiiiiii');
        });
    },

    methods: {
        teste: function() {
            axios.post(route('socketi.teste'))
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
