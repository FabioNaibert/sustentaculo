<template>
    <div class="card bg-white shadow-sm sm:rounded-lg">
        <div class="c-text text-gray-900">
            <h3>{{ player.name }}</h3>
            <div class="c-info">
                <div class="info__attribute">
                    <div
                        v-for="attribute in storeAttributes"
                        :key="attribute.id"
                    >
                        <div class="attribute" v-if="showAttributeBar(attribute.currentPoints) || showAll">
                            <p>{{ attribute.name }}</p>
                            <AttributeBar v-if="showAttributeBar(attribute.currentPoints)"
                                :totalPoints="attribute.totalPoints"
                                :currentPoints="attribute.currentPoints"
                                :color="attribute.representationColor"
                            />
                            <div v-else class="attribute__points">{{attribute.totalPoints}}</div>
                        </div>
                    </div>
                </div>
                <RemoveButton @click="removePlayer"
                    :tooltip="tooltip"
                />
            </div>
        </div>
        <AccordionButton @click="showAllAttributes()" :rotate="showAll" :identifier="player.id"/>
    </div>
</template>

<script>
import AttributeBar from "@/Atoms/AttributeBar.vue";
import RemoveButton from "@/Atoms/RemoveButton.vue";
import AccordionButton from "@/Atoms/AccordionButton.vue";

export default {
    name: 'Player',

    components: {
        AttributeBar,
        RemoveButton,
        AccordionButton
    },

    props: [
        'player',
    ],

    data() {
        return {
            tooltip: 'Excluir inimigo',
            showAll: false,
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
        showAttributeBar: function(current) {
            return current !== null && current !== undefined
        },

        removePlayer: function() {
            axios.post(route('enemy.remove'), {
                player_id: this.player.id,
                history_id: this.storeHistoryId
            })
            .then((response) => {
                this.$store.commit('updateEnemies', response.data)
            })
        },

        showAllAttributes: function() {
            this.showAll = !this.showAll
        }
    }

}
</script>

<style scoped>
h3 {
    text-align: center;
}

p {
    min-width: 4.5rem;
}

.card {
    width: 100%;
    overflow: hidden;
}

.c-text {
    padding: 0.2rem 1.5rem;
}

.attribute {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 1rem;
}

.c-info {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.info__attribute {
    flex-grow: 2;
}

.attribute__points {
    text-align: left;
}
</style>
