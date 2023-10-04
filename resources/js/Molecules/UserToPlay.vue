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
        'history_id'
    ],

    emits: [
        'upPlayers'
    ],

    data() {
        return {
            tooltip: 'Excluir jogador'
        }
    },

    computed: {
        storeAttributes: function() {
            return this.player.attributes
        }
    },

    methods: {
        removePlayer:function() {
            axios.post(route('player.remove'), {
                player_id: this.player.id,
                history_id: this.history_id
            })
            .then((response) => {
                this.$emit('upPlayers', response.data)
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

.attribute {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: nowrap;
    gap: 1rem;
}
</style>
