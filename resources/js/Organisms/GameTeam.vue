<template>
    <div class="players">
        <div v-for="player in storeTeam"
            :key="player.id"
            class="player"
        >
            <Player :player="player" />
        </div>
    </div>
</template>

<script>
import { orderBy } from 'lodash';
import Player from '@/Molecules/Player.vue';

export default {
    name: 'GameTeam',

    components: {
        Player
    },

    computed: {
        storeGameMobile: function() {
            return this.$store.getters.gameMobile
        },

        storeTeam: function() {
            return orderBy(this.storeGameMobile.team, ['name'])
        },
    },
}
</script>

<style scoped>
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
</style>
