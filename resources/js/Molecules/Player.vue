<template>
    <div class="card bg-white shadow-sm sm:rounded-lg">
        <div class="c-text p-6 text-gray-900">
            <h3>{{ player.name }}</h3>
            <div class="attribute"
                v-for="attribute in storeAttributes"
                :key="attribute.id"
            >
                {{ attribute.name }}
                <AttributeBar v-if="showAttributeBar(attribute.currentPoints)"
                    :totalPoints="attribute.totalPoints"
                    :currentPoints="attribute.currentPoints"
                    :color="attribute.representationColor"
                />
                <div v-else>{{attribute.totalPoints}}</div>
            </div>
        </div>
    </div>
</template>

<script>
import AttributeBar from "@/Atoms/AttributeBar.vue";

export default {
    name: 'Player',

    components: {
        AttributeBar
    },

    props: [
        'player'
    ],

    computed: {
        storeAttributes: function() {
            return this.player.attributes
        }
    },

    methods: {
        showAttributeBar: function(current) {
            return current !== null || current !== undefined
        }
    }

}
</script>

<style scoped>
h3 {
    text-align: center;
}

.attribute {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: nowrap;
    gap: 1rem;
}
</style>
