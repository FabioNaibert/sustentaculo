<template>
    <div class="card bg-white shadow-sm sm:rounded-lg">
        <div class="c-text text-gray-900">
            <h3>{{ storePlayer.name }}</h3>
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
            </div>
        </div>
        <AccordionButton @click="showAllAttributes()" :rotate="showAll" :identifier="storePlayer.id"/>
    </div>
</template>

<script>
import { orderBy } from 'lodash'
import AttributeBar from "@/Atoms/AttributeBar.vue";
import AccordionButton from "@/Atoms/AccordionButton.vue";

export default {
    name: 'Opponent',

    components: {
        AttributeBar,
        AccordionButton,
    },

    props: [
        'opponent',
    ],

    data() {
        return {
            tooltip: 'Excluir inimigo',
            showAll: false,
            oldAttributes: null,
        }
    },

    computed: {
        storePlayer: function() {
            return this.opponent
        },

        storeAttributes: function() {
            return orderBy(this.opponent.attributes, ['id'])
        },

        storeMasterId: function() {
            return this.$store.getters.historyMasterId
        },
    },

    methods: {
        showAttributeBar: function(current) {
            return current !== null && current !== undefined
        },

        showAllAttributes: function() {
            this.showAll = !this.showAll
        },

        updatePlayer: function() {
            axios.post(route('player.update'), {player: this.player})
            .then(() => {
            })
            .catch((error) => {
                console.error(error)
            })
            .finally(() => {})
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

.c-text{
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
    align-items: center;
}

.info__attribute {
    flex-grow: 2;
}

.attribute__points {
    text-align: left;
}

.c-actions {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 0.1rem;
}
</style>
