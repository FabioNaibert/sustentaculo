<template>
    <div class="players">
        <div v-if="storeResources.length > 0" class="player">
            <div v-for="resource in storeResources"
                :key="resource.id"
                class="player"
            >
                <Resource :resource="resource" />
            </div>
        </div>
        <div v-else>
            <div class="p-6 text-gray-900">Nenhum item encontrado.</div>
        </div>
    </div>
</template>

<script>
import { orderBy } from 'lodash';
import Resource from '@/Molecules/Resource.vue';

export default {
    name: 'GameResources',

    components: {
        Resource,
    },

    computed: {
        storeGameMobile: function() {
            return this.$store.getters.gameMobile
        },

        storeResources: function() {
            return orderBy(this.storeGameMobile.resoucers, ['name'])
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
