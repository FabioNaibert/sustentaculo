<template>
    <div class="players">
        <div v-for="weapon in storeBackpack"
            :key="weapon.id"
            class="player"
        >
            <Weapon :resource="weapon" />
        </div>
    </div>
</template>

<script>
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
            return this.storeGameMobile.backpack
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
