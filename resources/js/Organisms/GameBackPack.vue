<template>
    <div class="players">
        <div v-if="storeBackpack.length > 0" class="player">
            <div v-for="weapon in storeBackpack"
                :key="weapon.id"
                class="player"
            >
                <Weapon :resource="weapon" />
            </div>
        </div>
        <div v-else>
            <div class="p-6 text-gray-900">Sua mochila está vazia.</div>
        </div>
    </div>
</template>

<script>
import { orderBy } from 'lodash';
import Weapon from '@/Molecules/Weapon.vue';

export default {
    name: 'GameBackPack',

    components: {
        Weapon,
    },

    computed: {
        storeGameMobile: function() {
            return this.$store.getters.gameMobile
        },

        storeBackpack: function() {
            return orderBy(this.storeGameMobile.backpack, ['name'])
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
