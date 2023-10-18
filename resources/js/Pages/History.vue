<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container__history">
            <div class="c-esquerda">
                <div class="esquerda__1">
                    <div class="players">
                        <div v-for="enemy in storeEnemies"
                            :key="enemy.id"
                            class="player"
                        >
                            <Player
                                :player="enemy"
                                :history_id="storeHistory.id"
                                @upPlayers="(upPlayers) => response.history.enemies = upPlayers"
                            />
                        </div>
                    </div>

                    <div>
                        <NewEnemy
                            :history_id="storeHistory.id"
                            :allAttributes="storeAllAttributes"
                            @newEnemies="(newEnemies) => response.history.enemies = newEnemies"
                        />
                    </div>
                </div>
                <hr>
                <div class="esquerda__2">
                    <div class="players">

                    </div>

                    <div>
                        <NewResource
                            :history_id="storeHistory.id"
                            :allAttributes="storeAllAttributes"
                        />
                    </div>
                </div>
            </div>

            <div class="c-meio"></div>

            <div class="c-direita">
                <div class="direita__1">
                    <div class="input__default">
                        <label class="label__default">PONTOS INICIAIS:</label>
                        <IntInput tooltip="Valor padrão: 5"
                            ref="intInput"
                            type="number"
                            class="mt-1 block"
                            placeholder="Valor padrão: 5"
                            v-model="defaultPoints"
                            :minValue="1"
                            @change="setValue"
                        />
                    </div>
                    <div class="players">
                        <div v-for="player in storePlayers"
                            :key="player.id"
                            class="player"
                        >
                            <!-- <Player :player="player" /> -->
                            <UserToPlay :player="player"
                                :history_id="storeHistory.id"
                                @upPlayers="(upPlayers) => response.history.players = upPlayers"
                            />
                        </div>
                    </div>

                    <div>
                        <NewPlayer :history_id="storeHistory.id"
                            :default_points="defaultPoints"
                            @newPlayers="(newPlayers) => response.history.players = newPlayers"
                        />
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
import IntInput from '@/Atoms/IntInput.vue';
import NewEnemy from '@/Molecules/NewEnemy.vue';
import UserToPlay from '@/Molecules/UserToPlay.vue';
import NewResource from '@/Molecules/NewResource.vue';

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
        NewPlayer,
        IntInput,
        NewEnemy,
        UserToPlay,
        NewResource
    },

    data() {
        return {
            addTooltip: 'Criar nova história',
            defaultPoints: 5
        }
    },

    created() {
        // console.log(this.response.history)
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
        },

        storeAllAttributes: function() {
            return this.response.allAttributes
        },
    },

    methods: {
        setValue: function() {
            if (this.defaultPoints < 1){
                return this.defaultPoints = 5
            }

            return this.defaultPoints = parseInt(this.defaultPoints)
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

    gap: 0.6rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.player {
    width: 100%;
}

.input__default {
    display: flex;
    align-content: center;
    gap: 0.5rem;
}

.label__default {
    white-space: nowrap;
    display: flex;
    align-self: center;
}
</style>
