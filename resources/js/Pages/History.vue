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
                            <Player :player="enemy" />
                        </div>
                    </div>

                    <div>
                        <NewEnemy />
                    </div>
                </div>
                <hr>
                <div class="esquerda__2">
                    <div class="players">
                        <div v-for="resource in storeResources"
                            :key="resource.id"
                            class="player"
                        >
                            <Resource :resource="resource" />
                        </div>
                    </div>

                    <div>
                        <NewResource />
                    </div>
                </div>
            </div>

            <div class="c-meio">
                <Chapter />
            </div>

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
                            <UserToPlay :player="player" />
                        </div>
                    </div>

                    <div>
                        <NewPlayer :default_points="defaultPoints" />
                    </div>
                </div>
                <hr>
                <div class="direita__2">
                    <div class="players">
                        <!-- <div v-for="sound in storeSounds"
                            :key="sound.id"
                            class="player"
                        > -->
                            <!-- <Sound :sound="sound" /> -->
                            <!-- <img src="/images/9/1698529702.png"> -->
                            <!-- <audio controls>
                                <source src="/images/9/audio1.mp3" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio> -->
                            <audio controls>
                                <source src="/sounds/1_explosion.mp3" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        <!-- </div> -->
                    </div>

                    <div>
                        <NewSound />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NewHistory from '@/Molecules/NewHistory.vue';
import Player from '@/Molecules/Player.vue';
import NewPlayer from '@/Molecules/NewPlayer.vue';
import IntInput from '@/Atoms/IntInput.vue';
import NewEnemy from '@/Molecules/NewEnemy.vue';
import UserToPlay from '@/Molecules/UserToPlay.vue';
import NewResource from '@/Molecules/NewResource.vue';
import Resource from '@/Molecules/Resource.vue';
import Chapter from '@/Organisms/Chapter.vue';
import Sound from '@/Molecules/Sound.vue';
import NewSound from '@/Molecules/NewSound.vue';

export default {
    name: 'History',

    props: ['response'],

    components: {
        AuthenticatedLayout,
        Head,
        NewHistory,
        Player,
        NewPlayer,
        IntInput,
        NewEnemy,
        UserToPlay,
        NewResource,
        Resource,
        Chapter,
        Sound,
        NewSound
    },

    created() {
        this.$store.commit('setHistory', this.response.history)
        this.$store.commit('setAllAttributes', this.response.allAttributes)
        // this.$store.dispatch('defineLastChapter')
    },

    data() {
        return {
            addTooltip: 'Criar nova história',
            defaultPoints: 5,
            teste: null
        }
    },

    computed: {
        storeHistoryId: function() {
            return this.$store.getters.historyId
        },

        storePlayers: function() {
            return this.$store.getters.players
        },

        storeEnemies: function() {
            return this.$store.getters.enemies
        },

        storeResources: function() {
            return this.$store.getters.resources
        },

        storeAllAttributes: function() {
            return this.$store.getters.allAttributes
        },

        storeChapter: function() {
            return this.$store.getters.chapter.id
        },

        storeChapter: function() {
            return this.$store.getters.chapter
        },

        storeSounds: function() {
            return this.$store.getters.sounds
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
