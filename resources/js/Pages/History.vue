<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container__history">
            <div class="c-esquerda">
                <div class="esquerda__1">
                    <div v-for="enemy in storeEnemies"
                        :key="enemy.id"
                        class="c-player"
                    >
                        <Player :player="enemy" />
                    </div>

                    <div>
                        <NewPlayer :history_id="storeHistory.id" />
                    </div>
                </div>
                <hr>
                <div class="esquerda__2"></div>
            </div>

            <div class="c-meio"></div>

            <div class="c-direita">
                <div class="direita__1">
                    <div class="players">
                        <div v-for="player in storePlayers"
                            :key="player.id"
                            class="c-player"
                        >
                            <Player :player="player" />
                            <Player :player="player" />
                            <Player :player="player" />
                            <Player :player="player" />
                            <Player :player="player" />
                            <Player :player="player" />
                            <Player :player="player" />
                        </div>
                    </div>

                    <div>
                        <NewPlayer :history_id="storeHistory.id" />
                    </div>
                </div>
                <hr>
                <div class="direita__2"></div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Molecules/Card.vue';
import { Head } from '@inertiajs/vue3';
import AddButton from '@/Atoms/AddButton.vue';
import NewHistory from '@/Molecules/NewHistory.vue';
import Player from '@/Molecules/Player.vue';
import NewPlayer from '@/Molecules/NewPlayer.vue';

export default {
    name: 'History',

    props: ['response'],

    components: {
        AuthenticatedLayout,
        Card,
        Head,
        AddButton,
        NewHistory,
        Player,
        NewPlayer
    },

    data() {
        return {
            addTooltip: 'Criar nova história'
        }
    },

    created() {
        console.log(this.response.history)
    },

    computed: {
        storeHistory: function() {
            return this.response.history
        },

        storePlayers: function() {
            return this.response.history.players
        },

        storeEnemies: function() {
            return this.response.history.enemies
        }
    }
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
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
}

.players {
    overflow-y: auto;
    width: 100%;
    height: 100%;
}

.c-player {
    width: 100%;
    gap: 0.6rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    /* overflow-y: auto; */
}
</style>
