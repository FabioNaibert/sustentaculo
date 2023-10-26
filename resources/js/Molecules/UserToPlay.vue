<template>
    <div class="card bg-white shadow-sm sm:rounded-lg">
            <h3>{{ player.name }}</h3>
            <RemoveButton @click="removePlayer"
                :tooltip="tooltip"
            />
    </div>
</template>

<script>
import RemoveButton from "@/Atoms/RemoveButton.vue";

export default {
    name: 'UserToPlay',

    components: {
        RemoveButton
    },

    props: [
        'player',
    ],

    data() {
        return {
            tooltip: 'Excluir jogador'
        }
    },

    computed: {
        storeAttributes: function() {
            return this.player.attributes
        },

        storeHistoryId: function() {
            return this.$store.getters.historyId
        },
    },

    methods: {
        removePlayer:function() {
            axios.post(route('player.remove'), {
                player_id: this.player.id,
                history_id: this.storeHistoryId
            })
            .then((response) => {
                this.$store.commit('updatePlayers', response.data)
            })
        }
    }

}
</script>

<style scoped>
h3 {
    text-align: center;
}

.card {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 3rem;
    padding: 0.8rem;
}
</style>
